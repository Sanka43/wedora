#!/usr/bin/env python3
import os
import sys
import ftplib
import urllib.request
import urllib.error
import glob
import posixpath

def log(msg):
    print(f"[DEPLOY] {msg}", flush=True)

server = os.environ.get('FTP_SERVER')
username = os.environ.get('FTP_USERNAME')
password = os.environ.get('FTP_PASSWORD')
port = int(os.environ.get('FTP_PORT') or 21)
app_url = os.environ.get('APP_URL', 'https://wedora.rubiksacademy.live').rstrip('/')
deploy_secret = os.environ.get('DEPLOY_SECRET', 'wedora_sec_9f48a1c73e04b68e21908bf')

if not server or not username or not password:
    log("ERROR: FTP credentials missing.")
    sys.exit(1)

log(f"Connecting to {server}:{port} as {username}...")

ftp = None
try:
    ftp = ftplib.FTP_TLS()
    ftp.connect(server, port, timeout=30)
    ftp.login(username, password)
    ftp.prot_p()
    log("FTPS (TLS) connection established.")
except Exception as e:
    log(f"FTPS failed ({e}), attempting standard FTP...")
    ftp = ftplib.FTP()
    ftp.connect(server, port, timeout=30)
    ftp.login(username, password)
    log("Standard FTP connection established.")

pwd = ftp.pwd()
log(f"Initial FTP Directory: {pwd}")
root_items = []
try:
    root_items = ftp.nlst()
    log(f"Root contents: {root_items}")
except Exception as e:
    log(f"Could not list root: {e}")

# Determine the Laravel root directory on FTP
target_dir = pwd
# Check if artisan exists in current directory
if 'artisan' in root_items:
    log("Found 'artisan' in initial directory -> This is the Laravel project root.")
elif 'wedora.rubiksacademy.live' in root_items:
    target_dir = 'wedora.rubiksacademy.live'
    log(f"Changing directory to: {target_dir}")
    ftp.cwd(target_dir)
elif 'public_html' in root_items:
    # Check if artisan is inside public_html or in a subfolder of public_html
    ftp.cwd('public_html')
    p_items = ftp.nlst()
    log(f"public_html contents: {p_items}")
    if 'artisan' in p_items:
        target_dir = 'public_html'
        log("Found 'artisan' inside public_html.")
    elif 'wedora' in p_items:
        target_dir = 'public_html/wedora'
        ftp.cwd('wedora')
        log("Found 'wedora' inside public_html.")
    else:
        ftp.cwd('..')

log(f"Active Working Directory for Deployment: {ftp.pwd()}")
active_items = ftp.nlst()
log(f"Active directory items: {active_items}")

def ensure_remote_dir(remote_path):
    parts = remote_path.strip('/').split('/')
    cur = ""
    for part in parts:
        if not part:
            continue
        cur += "/" + part
        try:
            ftp.mkd(part)
        except Exception:
            pass
        try:
            ftp.cwd(part)
        except Exception:
            pass
    # return back to base
    ftp.cwd(ftp_base_dir)

ftp_base_dir = ftp.pwd()

def upload_file(local_path, remote_path):
    remote_dir = posixpath.dirname(remote_path)
    remote_filename = posixpath.basename(remote_path)
    
    if remote_dir:
        ensure_remote_dir(remote_dir)
        ftp.cwd(remote_dir)
    
    with open(local_path, 'rb') as f:
        log(f"Uploading: {local_path} -> {remote_path}")
        ftp.storbinary(f"STOR {remote_filename}", f)
    
    ftp.cwd(ftp_base_dir)

# 1. Upload critical views, configs, routes, scripts
critical_files = [
    'resources/views/welcome.blade.php',
    'resources/css/app.css',
    'routes/web.php',
    'public/system-cache-clear.php',
    'public/wedora-live-check.txt',
    'public/robots.txt',
    'public/index.php',
]

for cf in critical_files:
    if os.path.exists(cf):
        try:
            upload_file(cf, cf)
        except Exception as e:
            log(f"Failed to upload {cf}: {e}")

# 2. Upload public/build assets & manifest
build_files = glob.glob('public/build/**', recursive=True)
for bf in build_files:
    if os.path.isfile(bf):
        norm_bf = bf.replace('\\', '/')
        try:
            upload_file(norm_bf, norm_bf)
        except Exception as e:
            log(f"Failed to upload build asset {norm_bf}: {e}")

# 3. Clean server-side cached views in storage/framework/views
try:
    log("Purging remote storage/framework/views/*.php...")
    ftp.cwd("storage/framework/views")
    view_files = ftp.nlst()
    del_count = 0
    for vf in view_files:
        if vf.endswith('.php'):
            try:
                ftp.delete(vf)
                del_count += 1
            except Exception:
                pass
    log(f"Deleted {del_count} compiled views from remote storage/framework/views.")
    ftp.cwd(ftp_base_dir)
except Exception as e:
    log(f"Could not purge storage/framework/views: {e}")
    ftp.cwd(ftp_base_dir)

# 4. Clean server-side bootstrap/cache/*.php
try:
    log("Purging remote bootstrap/cache/*.php...")
    ftp.cwd("bootstrap/cache")
    cache_files = ftp.nlst()
    del_count = 0
    for cf in cache_files:
        if cf.endswith('.php'):
            try:
                ftp.delete(cf)
                del_count += 1
            except Exception:
                pass
    log(f"Deleted {del_count} bootstrap cache files from remote bootstrap/cache.")
    ftp.cwd(ftp_base_dir)
except Exception as e:
    log(f"Could not purge bootstrap/cache: {e}")
    ftp.cwd(ftp_base_dir)

ftp.quit()
log("FTP transfer completed successfully.")

# 5. Trigger Remote Cache Clear & OPcache Reset
clear_url = f"{app_url}/system-cache-clear.php?token={deploy_secret}"
log(f"Triggering cache clear endpoint: {clear_url}")
try:
    req = urllib.request.Request(clear_url, headers={'User-Agent': 'WedoraDeployBot/1.0'})
    with urllib.request.urlopen(req, timeout=15) as resp:
        body = resp.read().decode('utf-8', errors='replace')
        log(f"Cache clear response:\n{body}")
except Exception as e:
    log(f"Remote cache clear HTTP call note: {e}")

log("=== Wedora Deployment Execution Completed ===")
