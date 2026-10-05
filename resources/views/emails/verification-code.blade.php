<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã xác minh tài khoản</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f8; font-family: 'Helvetica Neue', Arial, sans-serif; color: #333333;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
        <tr>
            <td align="center" style="padding: 40px 15px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; overflow: hidden;">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #ff9900, #ff7700); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: 0.5px;">Xác Minh Tài Khoản</h1>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 40px;">
                            <p style="margin: 0 0 16px; font-size: 16px; line-height: 1.6; color: #1f2937;">
                                Xin chào <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; font-size: 15px; line-height: 1.6; color: #4b5563;">
                                Cảm ơn bạn đã đăng ký tài khoản. Vui lòng sử dụng mã số xác minh (OTP) dưới đây để hoàn tất việc đăng ký:
                            </p>
                            
                            <!-- OTP Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 25px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="background-color: #fff8eb; border: 2px dashed #ff9900; border-radius: 10px; padding: 18px 24px; display: inline-block;">
                                            <span style="font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #d97706; font-family: monospace;">{{ $code }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0; font-size: 14px; line-height: 1.5; color: #6b7280; text-align: center;">
                                ⏱ Mã xác minh này có hiệu lực trong vòng <strong>15 phút</strong>.
                            </p>
                            <p style="margin: 12px 0 0; font-size: 13px; line-height: 1.5; color: #9ca3af; text-align: center;">
                                Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này để bảo vệ tài khoản.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #f3f4f6;">
                            <p style="margin: 0; font-size: 12px; color: #9ca3af;">
                                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Mọi quyền được bảo lưu.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
