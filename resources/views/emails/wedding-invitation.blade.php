<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Wedding Planning Invitation — Wedora</title>
</head>
<body style="background-color: #0c0d12; color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 40px 20px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 560px; background-color: #14161f; border: 1px solid rgba(212, 175, 55, 0.3); border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
        <!-- Header -->
        <tr>
            <td style="padding: 30px 40px; text-align: center; background: linear-gradient(135deg, #1e1507 0%, #14161f 100%); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div style="font-size: 26px; font-weight: bold; color: #ffffff; letter-spacing: -0.5px;">
                    Wedora<span style="color: #d4af37;">.</span>
                </div>
                <div style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: rgba(212, 175, 55, 0.8); margin-top: 2px; font-weight: 600;">
                    Sri Lanka Wedding Planning
                </div>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 40px; text-align: center;">
                <div style="display: inline-block; background-color: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.3); color: #d4af37; padding: 4px 14px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
                    Co-Planning Invitation
                </div>

                <h1 style="color: #ffffff; font-size: 24px; font-weight: bold; margin: 0 0 16px; line-height: 1.3;">
                    You're Invited to Plan Together!
                </h1>

                <p style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin: 0 0 24px;">
                    <strong style="color: #ffffff;">{{ $inviter?->name ?? 'A couple' }}</strong> has invited you to co-plan
                    <strong style="color: #d4af37;">{{ $wedding->title }}</strong> on Wedora as their
                    <strong style="color: #ffffff;">{{ $invitation->role->label() }}</strong>.
                </p>

                <div style="background-color: #0c0d12; border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 16px; margin: 0 0 30px; text-align: left; font-size: 13px;">
                    <div style="color: #94a3b8; margin-bottom: 6px;">
                        <strong style="color: #ffffff;">Celebration:</strong> {{ $wedding->title }}
                    </div>
                    <div style="color: #94a3b8; margin-bottom: 6px;">
                        <strong style="color: #ffffff;">Tradition:</strong> {{ $wedding->wedding_type->label() }}
                    </div>
                    <div style="color: #94a3b8;">
                        <strong style="color: #ffffff;">District:</strong> {{ $wedding->district }}
                    </div>
                </div>

                <!-- CTA Button -->
                <div style="margin-bottom: 30px;">
                    <a href="{{ $inviteUrl }}" style="background: linear-gradient(135deg, #c5a059 0%, #d4af37 50%, #996515 100%); color: #0c0d12; padding: 14px 32px; border-radius: 10px; font-size: 13px; font-weight: bold; text-decoration: none; display: inline-block; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);">
                        Accept Invitation & Join Workspace
                    </a>
                </div>

                <p style="color: #64748b; font-size: 12px; line-height: 1.5; margin: 0;">
                    Or copy and paste this link into your browser:<br>
                    <a href="{{ $inviteUrl }}" style="color: #d4af37; text-decoration: underline; word-break: break-all;">
                        {{ $inviteUrl }}
                    </a>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="padding: 20px 40px; text-align: center; border-top: 1px solid rgba(255,255,255,0.05); font-size: 11px; color: #64748b;">
                &copy; {{ date('Y') }} Wedora Sri Lanka. If you did not expect this invitation, you can safely ignore this email.
            </td>
        </tr>
    </table>
</body>
</html>
