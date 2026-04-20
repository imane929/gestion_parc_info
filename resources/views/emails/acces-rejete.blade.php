<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Refusé</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9ff;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9ff;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ba1a1a 0%, #93000a 100%); padding: 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">Accès Refusé</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #121c2a; margin: 0 0 20px 0; font-size: 24px;">
                                Bonjour {{ $demande->prenom }} {{ $demande->nom }},
                            </h2>
                            
                            <p style="color: #424754; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                Nous regrettons de vous informer que votre demande d'accès à <strong>AssetFlow</strong> a été <strong style="color: #ba1a1a;">refusée</strong>.
                            </p>
                            
                            @if($demande->commentaire)
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ffdad6; border-radius: 12px; padding: 20px; margin: 20px 0;">
                                <tr>
                                    <td>
                                        <p style="margin: 0 0 5px 0; color: #93000a; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                                            Motif du refus
                                        </p>
                                        <p style="margin: 0; color: #121c2a; font-size: 15px; line-height: 1.5;">
                                            {{ $demande->commentaire }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            
                            <p style="color: #424754; font-size: 16px; line-height: 1.6; margin: 30px 0 20px 0;">
                                Si vous pensez qu'il s'agit d'une erreur ou si vous souhaitez plus d'informations, n'hésitez pas à nous contacter.
                            </p>
                            
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="mailto:assetflow.app@gmail.com" style="display: inline-block; background: linear-gradient(135deg, #0058be 0%, #2170e4 100%); color: #ffffff; padding: 15px 40px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 16px;">
                                    Nous contacter
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9ff; padding: 30px; text-align: center; border-top: 1px solid #e6eeff;">
                            <p style="color: #727785; font-size: 14px; margin: 0 0 10px 0;">
                                © {{ date('Y') }} AssetFlow - Gestion de Parc Informatique
                            </p>
                            <p style="color: #424754; font-size: 12px; margin: 0;">
                                Cet email a été envoyé automatiquement. Merci de ne pas y répondre.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
