@php
    $isFraud = $isFraud ?? true;
    $result = [
        'evaluation_id' => $evaluationId ?? 'BG-842-XO-2024',
        'transaction_id' => $transactionId ?? 'TXN-9842-BA',
        'risk_score' => $riskScore ?? ($isFraud ? 88 : 12),
        'confidence' => $confidence ?? ($isFraud ? 12 : 99.4),
        'pattern_match' => $patternMatch ?? ($isFraud ? 'Suspicious' : 'Norm'),
    ];
    $redFlags = $redFlags ?? [
        [
            'title' => 'Unusual geographic location',
            'description' => 'Request originated from a high-risk jurisdiction (Lagos, NG) inconsistent with user profile (New York, US).'
        ],
        [
            'title' => 'New device fingerprint',
            'description' => 'Access via a previously unassociated mobile browser with spoofed headers and non-standard resolution.'
        ],
        [
            'title' => 'Velocity threshold exceeded',
            'description' => '14 failed authorization attempts recorded within a 180-second window across three different merchant IDs.'
        ],
    ];
    $safeBehavior = $safeBehavior ?? [
        'Geographic Consistency' => 'Optimal',
        'Device Fingerprinting' => 'Verified',
        'Velocity Threshold' => 'Within Limits',
        'Anomaly Deviation' => '0.02%',
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ $isFraud ? 'Fraud Detected' : 'Detection Results' }} - BankGuard
    </title>

    <link rel="stylesheet" href="{{ asset('css/result.css') }}">
</head>
<body class="{{ $isFraud ? 'fraud-theme' : 'safe-theme' }}">

    <!-- Top Navbar -->
    <header class="topbar">
        <div class="brand-name">BankGuard</div>

        <div class="topbar-icons">
            <button class="icon-button" type="button" aria-label="Notification">
                ♧
            </button>

            <button class="icon-button" type="button" aria-label="Help">
                ?
            </button>

            <a href="{{ route('login') }}" class="profile-avatar" aria-label="Profile">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop" alt="Profile">
            </a>
        </div>
    </header>

    <main class="result-page">

        <!-- Status Banner -->
        <section class="status-banner">
            <div class="status-left">
                <div class="status-icon">
                    {{ $isFraud ? '!' : '🛡' }}
                </div>

                <div>
                    <h1>
                        {{ $isFraud ? 'Fraudulent Activity Detected' : 'No Fraud Detected' }}
                    </h1>

                    <p>
                        @if ($isFraud)
                            Our real-time monitoring system has flagged high-risk behavior on transaction {{ $result['transaction_id'] }}.
                        @else
                            The transaction cluster aligns with expected behavioral patterns.
                        @endif
                    </p>
                </div>
            </div>

            @if (!$isFraud)
                <div class="evaluation-id">
                    <p>EVALUATION ID</p>
                    <strong>{{ $result['evaluation_id'] }}</strong>
                </div>
            @endif
        </section>

        @if ($isFraud)
            <!-- Fraud Result Layout -->
            <section class="fraud-grid">

                <div class="fraud-main">
                    <div class="metrics-grid fraud-metrics">
                        <div class="metric-card">
                            <p>RISK SCORE</p>
                            <h3>{{ $result['risk_score'] }}<span>/100</span></h3>
                            <div class="risk-line"></div>
                        </div>

                        <div class="metric-card">
                            <p>LEGITIMACY CONFIDENCE</p>
                            <h3>{{ $result['confidence'] }}<span>%</span></h3>
                            <small class="danger-pill">Low Confidence</small>
                        </div>

                        <div class="metric-card">
                            <p>PATTERN MATCH</p>
                            <h3 class="pattern-danger">◈ {{ $result['pattern_match'] }}</h3>
                            <small>Synthetic Identity Heuristic</small>
                        </div>
                    </div>

                    <div class="red-flags-card">
                        <div class="red-flags-header">
                            <h2>System Red Flags</h2>
                            <span>{{ count($redFlags) }} CRITICAL ALERTS</span>
                        </div>

                        @foreach ($redFlags as $flag)
                            <div class="red-flag-row">
                                <div class="flag-icon">⊘</div>
                                <div>
                                    <h3>{{ $flag['title'] }}</h3>
                                    <p>{{ $flag['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="action-row">
                        <button type="button" class="danger-button">✹ Freeze Transaction</button>
                        <button type="button" class="outline-button">⚐ Report to Bank</button>
                        <button type="button" class="outline-button">▣ Review Detailed Logs</button>
                    </div>
                </div>

                <aside class="immediate-card">
                    <h2>Immediate Steps</h2>

                    <ul>
                        <li>Disable all outbound transfers immediately.</li>
                        <li>Change master PIN and login credentials via a secure device.</li>
                        <li>Revoke all active OAuth sessions in settings.</li>
                    </ul>
                </aside>

            </section>
        @else
            <!-- Safe Result Layout -->
            <section class="safe-grid">

                <div class="safe-main">
                    <h2>Evaluation Metrics</h2>

                    <div class="metrics-grid">
                        <div class="metric-card">
                            <p>RISK SCORE</p>
                            <h3>{{ $result['risk_score'] }} <span>/100</span></h3>
                            <small>Low probability</small>
                        </div>

                        <div class="metric-card">
                            <p>CONFIDENCE</p>
                            <h3>{{ $result['confidence'] }} <span>%</span></h3>
                            <small>High certainty</small>
                        </div>

                        <div class="metric-card">
                            <p>PATTERN MATCH</p>
                            <h3>{{ $result['pattern_match'] }}</h3>
                            <small>Standard behavior</small>
                        </div>
                    </div>

                    <div class="behavior-card">
                        <div class="behavior-header">
                            <h3>Behavioral Analysis</h3>
                            <span>▣</span>
                        </div>

                        @foreach ($safeBehavior as $label => $value)
                            <div class="behavior-row">
                                <p>{{ $label }}</p>
                                <strong>{{ $value }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>

                <aside class="trust-content">
                    <h2>Trust Indicators</h2>

                    <div class="trust-card dark-card">
                        <p class="trust-label">🛡 SECURE VIGILANCE</p>
                        <h3>Encryption Active</h3>
                        <p>
                            Every data point in this evaluation has been cross-referenced
                            with BankGuard's proprietary vault using 256-bit end-to-end encryption.
                        </p>
                    </div>

                    <div class="trust-card light-card">
                        <div class="trust-item">
                            <span>↺</span>
                            <div>
                                <h4>History Log</h4>
                                <p>Profile maintains 24 months of clean history.</p>
                            </div>
                        </div>

                        <div class="trust-item">
                            <span>🏛</span>
                            <div>
                                <h4>Institution Verification</h4>
                                <p>Confirmed with 3 partner nodes.</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('predict') }}" class="back-button">
                        <span>←</span>
                        Back to Dashboard
                    </a>
                </aside>

            </section>
        @endif

    </main>

    <footer class="footer">
        <div class="footer-brand">
            <h3>BankGuard</h3>
            <p>© 2024 BankGuard Systems. All rights reserved. Secure Vigilance Monitoring.</p>
        </div>

        <nav class="footer-links">
            <a href="{{ route('about') }}">About Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Security Disclosure</a>
            <a href="#">Contact Support</a>
        </nav>
    </footer>
</body>
</html>