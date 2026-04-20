<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8f9ff;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); padding: 30px; text-align: center; border-radius: 16px 16px 0 0;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">Nouveau message de contact</h1>
        </div>
        
        <!-- Content -->
        <div style="background-color: #ffffff; padding: 40px; border-radius: 0 0 16px 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
            <h2 style="color: #121c2a; margin: 0 0 20px 0; font-size: 20px;">
                Nouveau message reçu
            </h2>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff;">
                        <strong style="color: #727785; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Nom</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff; color: #121c2a; font-size: 16px;">
                        {{ $nom }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff;">
                        <strong style="color: #727785; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Email</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff;">
                        <a href="mailto:{{ $email }}" style="color: #0058be; font-size: 16px;">{{ $email }}</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff;">
                        <strong style="color: #727785; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Sujet</strong>
                    </td>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e6eeff; color: #121c2a; font-size: 16px;">
                        {{ $sujet }}
                    </td>
                </tr>
            </table>
            
            <div style="background-color: #f8f9ff; border-radius: 12px; padding: 20px; margin-top: 20px;">
                <p style="margin: 0 0 10px 0; color: #727785; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Message</p>
                <p style="margin: 0; color: #424754; font-size: 15px; line-height: 1.7; white-space: pre-wrap;">{{ $message }}</p>
            </div>
            
            <div style="margin-top: 30px; padding: 15px; background-color: #e6eeff; border-radius: 8px; text-align: center;">
                <p style="margin: 0; color: #0058be; font-size: 14px;">
                    Répondre à ce message → <a href="mailto:{{ $email }}" style="color: #0058be; text-decoration: none; font-weight: bold;">{{ $email }}</a>
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="padding: 25px; text-align: center;">
            <p style="color: #727785; font-size: 12px; margin: 0;">
                Ce message a été envoyé depuis le formulaire de contact du site AssetFlow
            </p>
        </div>
    </div>
</body>
</html>
