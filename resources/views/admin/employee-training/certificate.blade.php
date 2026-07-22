<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Training - {{ $test->name }}</title>
    <style>
        body {
            background: #fff;
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: "Times New Roman", Times, serif;
            color: #333;
        }
        .certificate-wrapper {
            padding: 5px;
            background-color: #dfb152; /* Gold border color matching reference */
            width: 100%;
            max-width: 1000px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .certificate-inner {
            background: #fff;
            padding: 5px;
        }
        .certificate-content {
            border: 3px solid #dfb152;
            padding: 60px 80px;
            text-align: center;
            background: #fff;
            min-height: 550px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .title {
            font-size: 64px;
            font-weight: bold;
            color: #777; /* Gray title matching reference */
            margin-bottom: 20px;
        }
        .subtitle {
            font-size: 28px;
            font-style: italic;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .employee-name {
            font-size: 42px;
            font-weight: bold;
            margin: 0 auto 30px auto;
            border-bottom: 1px solid #a3a3a3;
            width: 85%;
            padding-bottom: 15px;
        }
        .completed-text {
            font-size: 24px;
            font-style: italic;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .course-name {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 70px;
        }
        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: auto;
        }
        .signature-block {
            text-align: center;
            width: 33%;
        }
        .signature-line {
            font-size: 20px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
        .signature-label {
            font-size: 14px;
            color: #000;
        }
        .signature-sublabel {
            font-size: 12px;
            font-style: italic;
            color: #000;
        }
        .logo-block {
            width: 33%;
            text-align: center;
        }
        .logo-block img {
            max-width: 140px;
            height: auto;
        }
        @media print {
            body {
                padding: 0;
                background: none;
                align-items: flex-start;
            }
            .certificate-wrapper {
                box-shadow: none;
                max-width: 100%;
                height: 98vh; /* Force fill printed page */
            }
            .certificate-content {
                height: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate-inner">
            <div class="certificate-content">
                <div class="title">Certificate of Training</div>
                
                <div class="subtitle">This is to certify that</div>
                
                <div class="employee-name">
                    {{ $employee->name }}
                </div>
                
                <div class="completed-text">
                    has successfully completed the training program
                </div>
                
                <div class="course-name">
                    {{ $test->name }}
                </div>
                
                <div class="footer-section">
                    <div class="signature-block">
                        <div class="signature-line">{{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</div>
                        <div class="signature-label">Training Completed On</div>
                    </div>
                    
                    <div class="logo-block">
                        <img src="{{ asset('img/logo/logo.png') }}" alt="Infection Controls">
                    </div>
                    
                    <div class="signature-block">
                        <div class="signature-line">Christopher Truitt, Ph.D.</div>
                        <div class="signature-label">Training Instructor</div>
                        <div class="signature-sublabel">Signed Electronically On: {{ \Carbon\Carbon::parse($attempt->submitted_at)->format('m/d/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Optional: automatically prompt to print or just leave as a clean web view
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
