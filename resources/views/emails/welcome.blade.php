<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.emails.welcome.subject') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .title {
            font-size: 28px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: #6b7280;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #1f2937;
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: #4b5563;
        }
        .philosophy {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-left: 4px solid #0ea5e9;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
        }
        .philosophy h3 {
            color: #0c4a6e;
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
        }
        .philosophy p {
            color: #075985;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 12px;
        }
        .philosophy p:last-child {
            margin-bottom: 0;
            font-style: italic;
        }
        .features {
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .features h3 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .features ul {
            list-style: none;
            padding: 0;
        }
        .features li {
            padding: 8px 0;
            color: #4b5563;
            position: relative;
            padding-left: 25px;
        }
        .features li:before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        .cta {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #1d4ed8;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #2563eb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ $appName }}</div>
            <h1 class="title">{{ __('app.emails.welcome.title', ['app' => $app]) }}</h1>
            <p class="subtitle">{{ __('app.emails.welcome.subtitle') }}</p>
        </div>

        <div class="content">
            <div class="greeting">
                {{ __('app.emails.welcome.greeting', ['name' => $user->name]) }}
            </div>

            <div class="message">
                {{ __('app.emails.welcome.message') }}
            </div>

            <div class="philosophy">
                <h3>{{ __('app.emails.welcome.philosophy_title') }}</h3>
                <p>{{ __('app.emails.welcome.philosophy_message') }}</p>
                <p>{{ __('app.emails.welcome.philosophy_vision', ['app' => $app]) }}</p>
            </div>

            <div class="features">
                <h3>{{ __('app.emails.welcome.features_title', ['app' => $app]) }}</h3>
                <ul>
                    <li>{{ __('app.emails.welcome.feature_1') }}</li>
                    <li>{{ __('app.emails.welcome.feature_2') }}</li>
                    <li>{{ __('app.emails.welcome.feature_3') }}</li>
                    <li>{{ __('app.emails.welcome.feature_4') }}</li>
                </ul>
            </div>

            <div class="message">
                {{ __('app.emails.welcome.get_started') }}
            </div>

            <div class="cta">
                <a href="{{ $appUrl }}/dashboard" class="btn">
                    {{ __('app.emails.welcome.cta_button') }}
                </a>
            </div>
        </div>

        <div class="footer">
            <p>{{ __('app.emails.welcome.footer_message') }}</p>
            <p>
                <a href="{{ $appUrl }}">{{ $appUrl }}</a>
            </p>
        </div>
    </div>
</body>
</html>
