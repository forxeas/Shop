<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение почты</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8f9fa; font-family: Arial, sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f8f9fa; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <tr>
                    <td style="padding: 40px 30px; text-align: center;">
                        <h2 style="color: #0d6efd; margin: 0 0 20px 0; font-size: 24px;">
                            Подтвердите ваш аккаунт
                        </h2>

                        <p style="font-size: 16px; color: #212529; margin: 0 0 25px 0; line-height: 1.5;">
                            Спасибо за регистрацию! Для активации аккаунта используйте код ниже:
                        </p>

                        <div style="display: inline-block; padding: 15px 25px; background-color: #f8f9fa; border: 2px solid #0d6efd; border-radius: 8px; font-size: 32px; font-weight: bold; letter-spacing: 3px; margin: 20px 0; color: #0d6efd;">
                            {{ $code }}
                        </div>

                        <p style="margin: 30px 0 0 0; font-size: 14px; color: #6c757d; line-height: 1.5;">
                            Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>