@props([
    'title' => 'Portal — Wedora',
    'portalName' => 'Portal',
    'portalBadgeClass' => 'bg-amber-100 text-[#8c6d23] border border-amber-300',
])

@include('layouts.portal', [
    'title' => $title,
    'portalName' => $portalName,
    'portalBadgeClass' => $portalBadgeClass,
    'slot' => $slot,
])
