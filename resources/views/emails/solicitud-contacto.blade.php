<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nueva solicitud de contacto</title>
</head>
<body style="margin:0; padding:0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f9fafb;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f9fafb; padding:40px 20px">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background:white; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08)">
                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #f59e0b, #d97706); padding:40px 30px; text-align:center;">
                            <h1 style="color:white; margin:0; font-size:28px; font-weight:800">🔔 Nueva solicitud</h1>
                            <p style="color:rgba(255,255,255,0.9); margin:10px 0 0; font-size:16px">Tienes un cliente interesado en una propiedad</p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:40px 30px;">
                            <p style="font-size:16px; color:#111827; margin:0 0 20px">Hola <strong>{{ $solicitud->propiedad->agente->usuario->name }}</strong>,</p>

                            <p style="font-size:15px; color:#374151; line-height:1.6; margin:0 0 25px">
                                Recibiste una nueva solicitud de contacto para tu propiedad publicada en InmoTech.
                            </p>

                            <!-- PROPIEDAD -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f9fafb; border-radius:12px; padding:20px; margin-bottom:25px">
                                <tr>
                                    <td>
                                        <small style="color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; font-weight:700; font-size:12px">Propiedad</small>
                                        <h3 style="margin:8px 0 5px; color:#0f172a; font-size:18px">{{ $solicitud->propiedad->titulo }}</h3>
                                        <p style="margin:0; color:#6b7280; font-size:14px">📍 {{ $solicitud->propiedad->colonia->nombre }}, {{ $solicitud->propiedad->colonia->municipio->nombre }}</p>
                                        <p style="margin:8px 0 0; color:#d97706; font-size:20px; font-weight:800">${{ number_format($solicitud->propiedad->precio, 0) }}</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CLIENTE -->
                            <h4 style="color:#0f172a; margin:0 0 15px; font-size:16px">📞 Datos del cliente:</h4>
                            <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background:#fef3c7; border-left:4px solid #f59e0b; border-radius:8px; margin-bottom:25px">
                                <tr><td style="padding:8px 15px; color:#92400e"><strong>Nombre:</strong> {{ $solicitud->nombre_contacto }}</td></tr>
                                <tr><td style="padding:8px 15px; color:#92400e"><strong>Email:</strong> <a href="mailto:{{ $solicitud->email_contacto }}" style="color:#d97706; text-decoration:none">{{ $solicitud->email_contacto }}</a></td></tr>
                                @if($solicitud->telefono_contacto)
                                <tr><td style="padding:8px 15px; color:#92400e"><strong>Telefono:</strong> <a href="tel:{{ $solicitud->telefono_contacto }}" style="color:#d97706; text-decoration:none">{{ $solicitud->telefono_contacto }}</a></td></tr>
                                @endif
                            </table>

                            <!-- MENSAJE -->
                            <h4 style="color:#0f172a; margin:0 0 15px; font-size:16px">💬 Mensaje:</h4>
                            <div style="background:#f3f4f6; border-radius:12px; padding:20px; font-size:15px; color:#374151; line-height:1.7; margin-bottom:30px; font-style:italic">
                                "{{ $solicitud->mensaje }}"
                            </div>

                            <!-- CTA -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <a href="mailto:{{ $solicitud->email_contacto }}" style="display:inline-block; background:linear-gradient(135deg,#f59e0b,#d97706); color:white; text-decoration:none; padding:14px 32px; border-radius:10px; font-weight:700; font-size:15px; box-shadow:0 8px 20px rgba(245,158,11,0.4)">
                                            Responder al cliente →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:30px 0 0; font-size:13px; color:#6b7280; text-align:center; line-height:1.6">
                                Recibido el {{ $solicitud->created_at->format('d/m/Y \a \l\a\s H:i') }}<br>
                                Responde rapido para aumentar las posibilidades de cierre.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#0f172a; padding:25px 30px; text-align:center;">
                            <p style="color:white; margin:0 0 5px; font-size:14px; font-weight:700">InmoTech</p>
                            <p style="color:rgba(255,255,255,0.6); margin:0; font-size:12px">La plataforma inmobiliaria de Mexico</p>
                        </td>
                    </tr>
                </table>
                <p style="color:#9ca3af; font-size:12px; margin:20px 0 0; text-align:center">
                    Este email fue enviado automaticamente desde InmoTech. No respondas directamente a este correo.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
