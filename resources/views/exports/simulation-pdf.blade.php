<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $project->name }} - Rapport de Simulation</title>
    <style>
        @page { margin: 10mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 7.5pt; color: #2d3436; margin: 0; padding: 0; }

        /* ── Palette ── */
        :root { }
        .bg-dark { background-color: #0a1628; }
        .bg-canvas { background-color: #edf2f7; }

        /* ── Banner ── */
        .banner { background-color: #0a1628; color: #fff; padding: 14px 22px; margin: -10mm -10mm 10px -10mm; position: relative; overflow: hidden; }
        .banner::after { content: ''; position: absolute; right: -30px; top: -30px; width: 120px; height: 120px; background-color: rgba(67,97,238,0.15); border-radius: 50%; }
        .banner .brand { font-size: 6pt; color: #64ffda; text-transform: uppercase; letter-spacing: 3px; font-weight: bold; margin-bottom: 3px; }
        .banner h1 { font-size: 17pt; margin: 0; font-weight: bold; }
        .banner .sub { font-size: 8pt; color: #8892b0; margin-top: 2px; }
        .banner .stamp { text-align: right; font-size: 7pt; color: #4a5568; margin-top: -20px; }

        /* ── Cards ── */
        .card { background: #fff; border-radius: 5px; padding: 10px 13px; margin-bottom: 7px; border: 1px solid #e2e8f0; }
        .card-header { font-size: 7pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #718096; margin-bottom: 6px; padding-bottom: 4px; border-bottom: 2px solid #edf2f7; }
        .card-header .accent { color: #4361ee; }

        /* ── KPI Tiles ── */
        .kpi-row { width: 100%; border-collapse: separate; border-spacing: 5px 0; margin-bottom: 7px; }
        .kpi { background: #fff; border-radius: 5px; padding: 9px 6px; text-align: center; border: 1px solid #e2e8f0; vertical-align: top; }
        .kpi .bar { width: 100%; height: 3px; border-radius: 2px; margin-bottom: 5px; }
        .kpi .num { font-size: 14pt; font-weight: bold; line-height: 1.1; }
        .kpi .lbl { font-size: 5.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.6px; color: #718096; margin-top: 2px; }
        .kpi .sub { font-size: 6pt; color: #a0aec0; }

        /* ── Tables ── */
        .t { width: 100%; border-collapse: collapse; font-size: 7pt; }
        .t th { background: #0a1628; color: #fff; padding: 4px 3px; text-align: right; font-size: 5.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; }
        .t th:first-child { text-align: center; width: 26px; }
        .t td { padding: 3px; text-align: right; border-bottom: 1px solid #edf2f7; }
        .t td:first-child { text-align: center; font-weight: bold; color: #4361ee; }
        .t tr:nth-child(even) td { background: #f7fafc; }
        .t .tot td { background: #0a1628; color: #fff; font-weight: bold; border: none; }
        .pos { color: #00b894; }
        .neg { color: #d63031; }

        /* ── Bars ── */
        .hb { width: 100%; border-collapse: collapse; }
        .hb td { padding: 1px 0; vertical-align: middle; }
        .hb-y { width: 20px; text-align: center; font-size: 6pt; font-weight: bold; color: #2d3436; }
        .hb-track { height: 11px; border-radius: 2px; overflow: hidden; background: #edf2f7; }
        .hb-seg { height: 11px; float: left; }
        .hb-v { width: 38px; text-align: right; font-size: 5.5pt; color: #718096; padding-left: 3px; }

        /* ── Distribution ── */
        .dist td { padding: 3px 0; vertical-align: middle; font-size: 7pt; }
        .dist-dot { width: 8px; height: 8px; border-radius: 50%; }
        .dist-bar-bg { background: #edf2f7; height: 5px; border-radius: 3px; }
        .dist-bar { height: 5px; border-radius: 3px; }

        /* ── Cover ── */
        .cover { background-color: #0a1628; color: #fff; margin: -10mm; padding: 0; height: 100%; min-height: 800px; position: relative; }
        .cover-content { padding: 120px 60px 60px 60px; }
        .cover .brand-big { font-size: 9pt; color: #64ffda; text-transform: uppercase; letter-spacing: 5px; font-weight: bold; margin-bottom: 20px; }
        .cover h1 { font-size: 30pt; font-weight: bold; margin: 0 0 8px 0; line-height: 1.1; }
        .cover .subtitle { font-size: 13pt; color: #8892b0; margin-bottom: 40px; }
        .cover .divider { width: 60px; height: 3px; background: #4361ee; margin-bottom: 30px; border-radius: 2px; }
        .cover .info-grid { width: 100%; border-collapse: collapse; }
        .cover .info-grid td { padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 9pt; }
        .cover .info-grid .label { color: #64748b; width: 180px; }
        .cover .info-grid .value { color: #e2e8f0; font-weight: bold; }
        .cover .footer-cover { position: absolute; bottom: 40px; left: 60px; right: 60px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; }
        .cover .footer-cover .gen { font-size: 8pt; color: #4a5568; }
        .cover .circle1 { position: absolute; right: -80px; top: -80px; width: 300px; height: 300px; background: rgba(67,97,238,0.08); border-radius: 50%; }
        .cover .circle2 { position: absolute; right: 60px; bottom: 80px; width: 180px; height: 180px; background: rgba(100,255,218,0.06); border-radius: 50%; }

        /* ── Utils ── */
        .page-break { page-break-before: always; }
        .footer { text-align: center; font-size: 6pt; color: #a0aec0; margin-top: 6px; padding-top: 4px; border-top: 1px solid #e2e8f0; }
        .two-col { width: 100%; border-collapse: separate; border-spacing: 6px 0; }
        .two-col > tbody > tr > td { vertical-align: top; width: 50%; }
        .three-col { width: 100%; border-collapse: separate; border-spacing: 5px 0; }
        .three-col > tbody > tr > td { vertical-align: top; width: 33.33%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .small { font-size: 6pt; color: #a0aec0; }
    </style>
</head>
<body>

{{-- ================================================================ --}}
{{-- PAGE 1 : COVER PAGE                                              --}}
{{-- ================================================================ --}}
<div class="cover">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="cover-content">
        <div class="brand-big">COS-PETROGAZ</div>
        <h1>{{ $project->name }}</h1>
        <div class="subtitle">Rapport de Simulation Economique</div>
        <div class="divider"></div>

        <table class="info-grid">
            <tr><td class="label">Type de projet</td><td class="value">{{ ucfirst($project->type) }}</td></tr>
            <tr><td class="label">Code Petrolier</td><td class="value">{{ $project->petroleumCode?->name ?? 'Code ' . $project->code_petrolier }}</td></tr>
            <tr><td class="label">Duree</td><td class="value">{{ $project->duration }} ans</td></tr>
            <tr><td class="label">Scenario</td><td class="value">Base</td></tr>
            <tr><td class="label">VAN (NPV @ {{ $project->parameter->discount_rate ?? 10 }}%)</td><td class="value" style="color:#64ffda;">{{ number_format($npv, 1, ',', ' ') }} M$</td></tr>
            <tr><td class="label">TRI (IRR)</td><td class="value" style="color:#64ffda;">{{ $irr !== null ? number_format($irr, 1) . ' %' : 'N/A' }}</td></tr>
            <tr><td class="label">Investissement Total</td><td class="value">{{ number_format($totalInvestment, 1, ',', ' ') }} M$</td></tr>
            <tr><td class="label">Government Take</td><td class="value">{{ $govTake }} %</td></tr>
        </table>

        <div class="footer-cover">
            <div class="gen">Rapport genere automatiquement le {{ now()->format('d/m/Y') }} a {{ now()->format('H:i') }} &bull; COS-PETROGAZ Modelisation Economique</div>
        </div>
    </div>
</div>

{{-- ================================================================ --}}
{{-- PAGE 2 : DASHBOARD KPIs + CHARTS                                --}}
{{-- ================================================================ --}}
<div class="page-break"></div>
<div class="banner">
    <div class="brand">COS-PETROGAZ</div>
    <h1>Tableau de Bord</h1>
    <div class="sub">{{ $project->name }} &bull; Indicateurs cles et repartition</div>
    <div class="stamp">Page 2/5</div>
</div>

{{-- Primary KPIs --}}
<table class="kpi-row">
<tr>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#4361ee;"></div>
        <div class="num" style="color:#4361ee;">{{ number_format($npv, 0, ',', ' ') }}</div>
        <div class="lbl">VAN (M$)</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#00b894;"></div>
        <div class="num" style="color:#00b894;">{{ $irr !== null ? number_format($irr, 1) . '%' : 'N/A' }}</div>
        <div class="lbl">TRI (IRR)</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#fdcb6e;"></div>
        <div class="num" style="color:#e17055;">{{ number_format($totalRevenue, 0, ',', ' ') }}</div>
        <div class="lbl">Revenu Brut (M$)</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#6c5ce7;"></div>
        <div class="num" style="color:#6c5ce7;">{{ $govTake }}%</div>
        <div class="lbl">Gov. Take</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#00cec9;"></div>
        <div class="num" style="color:#00cec9;">{{ $paybackYear ?? 'N/A' }}</div>
        <div class="lbl">Payback (An)</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#e17055;"></div>
        <div class="num" style="color:#e17055;">{{ $profitabilityIndex }}</div>
        <div class="lbl">Indice Profit.</div>
        <div class="sub">VAN / CAPEX</div>
    </td>
    <td class="kpi" style="width:14.2%;">
        <div class="bar" style="background:#fd79a8;"></div>
        <div class="num" style="color:#fd79a8;">{{ $peakProdVal }}</div>
        <div class="lbl">Pic Prod. (mboe/j)</div>
        <div class="sub">Annee {{ $peakProdYear ?? '-' }}</div>
    </td>
</tr>
</table>

<table class="two-col">
<tr>
    {{-- LEFT : Stacked bars --}}
    <td>
        <div class="card">
            <div class="card-header"><span class="accent">|</span> Cashflow Annuel (M$)</div>
            @php $maxRev = max(array_merge($revenues, [1])); @endphp
            <table class="hb">
                @foreach($labels as $i => $year)
                <tr>
                    <td class="hb-y">{{ $year }}</td>
                    <td>
                        <div class="hb-track">
                            @php
                                $stW = max((($stateShare[$i] ?? 0) / $maxRev) * 100, 0);
                                $opW = max((($operatorShare[$i] ?? 0) / $maxRev) * 100, 0);
                                $restW = max(($revenues[$i] / $maxRev) * 100 - $stW - $opW, 0);
                            @endphp
                            <div class="hb-seg" style="width:{{ $stW }}%; background:#4361ee;"></div>
                            <div class="hb-seg" style="width:{{ $opW }}%; background:#00b894;"></div>
                            <div class="hb-seg" style="width:{{ $restW }}%; background:#dfe6e9;"></div>
                        </div>
                    </td>
                    <td class="hb-v">{{ number_format($revenues[$i], 0) }}</td>
                </tr>
                @endforeach
            </table>
            <div style="margin-top:4px; font-size:5.5pt; color:#718096;">
                <span style="display:inline-block; width:7px; height:7px; background:#4361ee; border-radius:1px;"></span> Etat &nbsp;
                <span style="display:inline-block; width:7px; height:7px; background:#00b894; border-radius:1px;"></span> Operateur &nbsp;
                <span style="display:inline-block; width:7px; height:7px; background:#dfe6e9; border-radius:1px;"></span> Taxes/Autres
            </div>
        </div>
    </td>

    {{-- RIGHT : Distribution + VAN + Investment --}}
    <td>
        {{-- Revenue Split --}}
        <div class="card">
            <div class="card-header"><span class="accent">|</span> Repartition des Revenus</div>
            @php
                $distItems = [
                    ['l' => 'Part Senegal', 'v' => $totalState, 'c' => '#4361ee'],
                    ['l' => 'Part Operateur', 'v' => $totalOperator, 'c' => '#00b894'],
                    ['l' => 'Taxes & Fiscalite', 'v' => max($totalRevenue - $totalState - $totalOperator, 0), 'c' => '#fdcb6e'],
                ];
                $distMax = max(array_column($distItems, 'v') ?: [1]);
            @endphp
            <table class="dist" style="width:100%; border-collapse:collapse;">
                @foreach($distItems as $d)
                @php $pct = $totalRevenue > 0 ? round($d['v'] / $totalRevenue * 100, 1) : 0; @endphp
                <tr>
                    <td style="width:8px;"><div class="dist-dot" style="background:{{ $d['c'] }};"></div></td>
                    <td style="padding-left:5px; color:#4a5568;">{{ $d['l'] }}</td>
                    <td style="width:55px; text-align:right; font-weight:bold;">{{ number_format($d['v'], 0, ',', ' ') }}</td>
                    <td style="width:30px; text-align:right; font-size:6pt; color:#a0aec0;">{{ $pct }}%</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3" style="padding: 0 0 3px 0;">
                        <div class="dist-bar-bg"><div class="dist-bar" style="width:{{ ($d['v']/$distMax)*95 }}%; background:{{ $d['c'] }};"></div></div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        {{-- VAN Evolution mini chart --}}
        <div class="card">
            <div class="card-header"><span class="accent">|</span> VAN Cumulee (M$)</div>
            @php $maxNpvAbs = max(array_map('abs', $cumulativeNPV) ?: [1]); @endphp
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    @foreach($cumulativeNPV as $i => $val)
                    <td style="text-align:center; vertical-align:bottom; height:28px; padding:0 0.5px;">
                        @php $h = $maxNpvAbs > 0 ? abs($val)/$maxNpvAbs * 24 : 0; @endphp
                        <div style="background:{{ $val >= 0 ? '#00b894' : '#d63031' }}; width:85%; height:{{ max($h, 1) }}px; margin:0 auto; border-radius:1px;"></div>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach($cumulativeNPV as $val)
                    <td style="text-align:center; font-size:4.5pt; color:{{ $val >= 0 ? '#00b894' : '#d63031' }}; font-weight:bold; padding:1px 0;">{{ number_format($val, 0) }}</td>
                    @endforeach
                </tr>
                <tr>
                    @foreach($labels as $year)
                    <td style="text-align:center; font-size:4pt; color:#a0aec0;">{{ $year }}</td>
                    @endforeach
                </tr>
            </table>
        </div>

        {{-- Investment summary --}}
        <div class="card">
            <div class="card-header"><span class="accent">|</span> Investissements</div>
            @php
                $invItems = [
                    ['l' => 'CAPEX', 'v' => $totalCapex, 'c' => '#d63031'],
                    ['l' => 'OPEX', 'v' => $totalOpex, 'c' => '#e17055'],
                    ['l' => 'ABEX', 'v' => $totalAbex, 'c' => '#636e72'],
                ];
                $invMax = max(array_column($invItems, 'v') ?: [1]);
            @endphp
            <table class="dist" style="width:100%; border-collapse:collapse;">
                @foreach($invItems as $inv)
                <tr>
                    <td style="width:8px;"><div class="dist-dot" style="background:{{ $inv['c'] }};"></div></td>
                    <td style="padding-left:5px; color:#4a5568;">{{ $inv['l'] }}</td>
                    <td style="width:55px; text-align:right; font-weight:bold;">{{ number_format($inv['v'], 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="padding:0 0 2px 0;">
                        <div class="dist-bar-bg"><div class="dist-bar" style="width:{{ $invMax > 0 ? ($inv['v']/$invMax)*90 : 0 }}%; background:{{ $inv['c'] }};"></div></div>
                    </td>
                </tr>
                @endforeach
            </table>
            <div style="font-size:6pt; color:#718096; margin-top:3px; text-align:right;">Total: <strong>{{ number_format($totalInvestment, 0, ',', ' ') }} M$</strong></div>
        </div>
    </td>
</tr>
</table>

<div class="footer">COS-PETROGAZ &bull; {{ $project->name }} &bull; Rapport de Simulation &bull; Page 2/5</div>

{{-- ================================================================ --}}
{{-- PAGE 3 : PRODUCTION & CAPEX PROFILES                            --}}
{{-- ================================================================ --}}
<div class="page-break"></div>
<div class="banner">
    <div class="brand">COS-PETROGAZ</div>
    <h1>Profils d'Investissement & Production</h1>
    <div class="sub">{{ $project->name }} &bull; Evolution annuelle des entrees</div>
    <div class="stamp">Page 3/5</div>
</div>

<table class="two-col">
<tr>
    {{-- CAPEX Profile --}}
    <td>
        <div class="card">
            <div class="card-header"><span style="color:#d63031;">|</span> Profil CAPEX (M$)</div>
            @php $maxCap = max(array_column($capexProfile, 'total') ?: [1]); @endphp
            <table class="hb">
                @foreach($capexProfile as $cp)
                <tr>
                    <td class="hb-y">{{ $cp['year'] }}</td>
                    <td>
                        <div class="hb-track">
                            <div class="hb-seg" style="width:{{ $maxCap > 0 ? ($cp['total']/$maxCap)*100 : 0 }}%; background:#d63031;"></div>
                        </div>
                    </td>
                    <td class="hb-v">{{ $cp['total'] > 0 ? number_format($cp['total'], 0) : '-' }}</td>
                </tr>
                @endforeach
            </table>
            <div style="font-size:6pt; color:#718096; margin-top:3px; text-align:right;">Total CAPEX: <strong>{{ number_format($totalCapex, 0, ',', ' ') }} M$</strong></div>
        </div>
    </td>

    {{-- OPEX Profile --}}
    <td>
        <div class="card">
            <div class="card-header"><span style="color:#e17055;">|</span> Profil OPEX (M$)</div>
            @php $maxOp = max(array_column($opexProfile, 'total') ?: [1]); @endphp
            <table class="hb">
                @foreach($opexProfile as $op)
                <tr>
                    <td class="hb-y">{{ $op['year'] }}</td>
                    <td>
                        <div class="hb-track">
                            <div class="hb-seg" style="width:{{ $maxOp > 0 ? ($op['total']/$maxOp)*100 : 0 }}%; background:#e17055;"></div>
                        </div>
                    </td>
                    <td class="hb-v">{{ $op['total'] > 0 ? number_format($op['total'], 0) : '-' }}</td>
                </tr>
                @endforeach
            </table>
            <div style="font-size:6pt; color:#718096; margin-top:3px; text-align:right;">Total OPEX: <strong>{{ number_format($totalOpex, 0, ',', ' ') }} M$</strong></div>
        </div>
    </td>
</tr>
</table>

{{-- Production Profile --}}
<div class="card">
    <div class="card-header"><span style="color:#00b894;">|</span> Profil de Production (Equivalent Petrole mboe/j)</div>
    @php $maxProd = max(array_column($prodProfile, 'equiv') ?: [1]); @endphp
    <table class="hb">
        @foreach($prodProfile as $pp)
        <tr>
            <td class="hb-y">{{ $pp['year'] }}</td>
            <td>
                <div class="hb-track">
                    <div class="hb-seg" style="width:{{ $maxProd > 0 ? ($pp['equiv']/$maxProd)*100 : 0 }}%; background: linear-gradient(90deg, #00b894, #00cec9);"></div>
                </div>
            </td>
            <td class="hb-v">{{ $pp['equiv'] > 0 ? number_format($pp['equiv'], 1) : '-' }}</td>
            <td style="width:65px; text-align:right; font-size:5pt; color:#a0aec0;">
                @if($pp['oil'] > 0) Oil:{{ number_format($pp['oil'], 2) }}Mbbl @endif
                @if($pp['gnl'] > 0) GNL:{{ number_format($pp['gnl'], 2) }}MT @endif
            </td>
        </tr>
        @endforeach
    </table>
    <div style="font-size:6pt; color:#718096; margin-top:3px;">
        Pic de production: <strong>{{ $peakProdVal }} mboe/j</strong> (Annee {{ $peakProdYear ?? '-' }})
    </div>
</div>

<div class="footer">COS-PETROGAZ &bull; {{ $project->name }} &bull; Page 3/5</div>

{{-- ================================================================ --}}
{{-- PAGE 4 : CASHFLOW TABLE                                          --}}
{{-- ================================================================ --}}
<div class="page-break"></div>
<div class="banner">
    <div class="brand">COS-PETROGAZ</div>
    <h1>Cashflow Detaille</h1>
    <div class="sub">{{ $project->name }} &bull; Valeurs en M$ &bull; Scenario Base</div>
    <div class="stamp">Page 4/5</div>
</div>

<div class="card" style="padding:5px;">
<table class="t">
    <thead>
        <tr>
            <th>An</th><th>Rev. Brut</th><th>Redev.</th><th>Rev. Net</th>
            <th>Cost Rec.</th><th>Profit Oil</th><th>Etat</th><th>PETROSN</th>
            <th>Operat.</th><th>IS</th><th>CAPEX</th><th>OPEX</th><th>ABEX</th>
            <th>CF Projet</th><th>CF Act.</th><th>VAN Cum.</th>
        </tr>
    </thead>
    <tbody>
        @php $npvCum = 0; @endphp
        @foreach($cashflows as $cf)
            @php $npvCum += $cf->discounted_cashflow; @endphp
            <tr>
                <td>{{ $cf->year }}</td>
                <td>{{ number_format($cf->gross_revenue, 1) }}</td>
                <td>{{ number_format($cf->royalties, 1) }}</td>
                <td>{{ number_format($cf->net_revenue, 1) }}</td>
                <td>{{ number_format($cf->cost_recovery, 1) }}</td>
                <td>{{ number_format($cf->profit_oil, 1) }}</td>
                <td>{{ number_format($cf->state_share, 1) }}</td>
                <td>{{ number_format($cf->petrosen_share, 1) }}</td>
                <td>{{ number_format($cf->operator_share, 1) }}</td>
                <td>{{ number_format($cf->income_tax, 1) }}</td>
                <td>{{ number_format($cf->capex_total, 1) }}</td>
                <td>{{ number_format($cf->opex_total, 1) }}</td>
                <td>{{ number_format($cf->abex_total ?? 0, 1) }}</td>
                <td class="{{ $cf->project_cashflow >= 0 ? 'pos' : 'neg' }}">{{ number_format($cf->project_cashflow, 1) }}</td>
                <td class="{{ $cf->discounted_cashflow >= 0 ? 'pos' : 'neg' }}">{{ number_format($cf->discounted_cashflow, 1) }}</td>
                <td class="{{ $npvCum >= 0 ? 'pos' : 'neg' }}">{{ number_format($npvCum, 1) }}</td>
            </tr>
        @endforeach
        <tr class="tot">
            <td>TOTAL</td>
            <td>{{ number_format($cashflows->sum('gross_revenue'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('royalties'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('net_revenue'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('cost_recovery'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('profit_oil'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('state_share'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('petrosen_share'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('operator_share'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('income_tax'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('capex_total'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('opex_total'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('abex_total'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('project_cashflow'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('discounted_cashflow'), 1) }}</td>
            <td>{{ number_format($npvCum, 1) }}</td>
        </tr>
    </tbody>
</table>
</div>

<div class="footer">COS-PETROGAZ &bull; {{ $project->name }} &bull; Page 4/5</div>

{{-- ================================================================ --}}
{{-- PAGE 5 : STATE REVENUES                                          --}}
{{-- ================================================================ --}}
<div class="page-break"></div>
<div class="banner">
    <div class="brand">COS-PETROGAZ</div>
    <h1>Revenus Etatiques</h1>
    <div class="sub">{{ $project->name }} &bull; Repartition detaillee des revenus du Senegal</div>
    <div class="stamp">Page 5/5</div>
</div>

{{-- State KPIs --}}
@php
    $totalFisc = $cashflows->sum('income_tax') + $cashflows->sum('cel')
               + $cashflows->sum('export_tax') + $cashflows->sum('wht_dividendes')
               + $cashflows->sum('business_license_tax') + $cashflows->sum('royalties');
@endphp
<table class="kpi-row">
<tr>
    <td class="kpi" style="width:25%;"><div class="bar" style="background:#6c5ce7;"></div><div class="num" style="color:#6c5ce7;">{{ number_format($totalState, 0, ',', ' ') }}</div><div class="lbl">Revenus Etat (M$)</div></td>
    <td class="kpi" style="width:25%;"><div class="bar" style="background:#00b894;"></div><div class="num" style="color:#00b894;">{{ $govTake }}%</div><div class="lbl">Government Take</div></td>
    <td class="kpi" style="width:25%;"><div class="bar" style="background:#4361ee;"></div><div class="num" style="color:#4361ee;">{{ number_format($cashflows->sum('petrosen_share'), 0, ',', ' ') }}</div><div class="lbl">PETROSEN (M$)</div></td>
    <td class="kpi" style="width:25%;"><div class="bar" style="background:#fdcb6e;"></div><div class="num" style="color:#e17055;">{{ number_format($totalFisc, 0, ',', ' ') }}</div><div class="lbl">Fiscalite (M$)</div></td>
</tr>
</table>

{{-- Fiscal Waterfall --}}
<div class="card">
    <div class="card-header"><span style="color:#6c5ce7;">|</span> Decomposition Fiscale</div>
    @php
        $fiscItems = [
            ['l' => 'Redevances', 'v' => $cashflows->sum('royalties'), 'c' => '#4361ee'],
            ['l' => 'Profit Oil Etat', 'v' => $cashflows->sum('state_share'), 'c' => '#6c5ce7'],
            ['l' => 'Part PETROSEN', 'v' => $cashflows->sum('petrosen_share'), 'c' => '#00cec9'],
            ['l' => 'Impot Societe (IS)', 'v' => $cashflows->sum('income_tax'), 'c' => '#fdcb6e'],
            ['l' => 'CEL', 'v' => $cashflows->sum('cel'), 'c' => '#e17055'],
            ['l' => 'Taxe Export', 'v' => $cashflows->sum('export_tax'), 'c' => '#d63031'],
            ['l' => 'WHT Dividendes', 'v' => $cashflows->sum('wht_dividendes'), 'c' => '#636e72'],
            ['l' => 'Business License Tax', 'v' => $cashflows->sum('business_license_tax'), 'c' => '#b2bec3'],
        ];
        $maxFisc = max(array_column($fiscItems, 'v') ?: [1]);
    @endphp
    <table style="width:100%; border-collapse:collapse; font-size:7pt;">
        @foreach($fiscItems as $fi)
        @if($fi['v'] > 0.01)
        <tr>
            <td style="width:110px; padding:3px 6px 3px 0; color:#4a5568;">{{ $fi['l'] }}</td>
            <td style="padding:3px 0;">
                <div class="dist-bar-bg" style="height:9px;">
                    <div class="dist-bar" style="width:{{ ($fi['v']/$maxFisc)*88 }}%; background:{{ $fi['c'] }}; height:9px;"></div>
                </div>
            </td>
            <td style="width:55px; text-align:right; font-weight:bold; color:{{ $fi['c'] }};">{{ number_format($fi['v'], 1) }}</td>
            <td style="width:30px; text-align:right; font-size:5.5pt; color:#a0aec0;">{{ $totalState > 0 ? round($fi['v']/$totalState*100, 1) : 0 }}%</td>
        </tr>
        @endif
        @endforeach
    </table>
</div>

{{-- State revenue table --}}
<div class="card" style="padding:5px;">
<table class="t">
    <thead>
        <tr>
            <th>An</th><th>Redev.</th><th>Profit Oil</th><th>PETROSEN</th>
            <th>IS</th><th>CEL</th><th>Tx Export</th><th>WHT</th><th>BLT</th>
            <th>Total Etat</th><th>Gov. Take</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cashflows as $cf)
            @php
                $te = $cf->royalties + $cf->state_share + $cf->petrosen_share
                    + $cf->income_tax + $cf->cel + $cf->export_tax
                    + ($cf->wht_dividendes ?? 0) + ($cf->business_license_tax ?? 0);
                $gt = $cf->gross_revenue > 0 ? round($te / $cf->gross_revenue * 100, 1) : 0;
            @endphp
            <tr>
                <td>{{ $cf->year }}</td>
                <td>{{ number_format($cf->royalties, 1) }}</td>
                <td>{{ number_format($cf->state_share, 1) }}</td>
                <td>{{ number_format($cf->petrosen_share, 1) }}</td>
                <td>{{ number_format($cf->income_tax, 1) }}</td>
                <td>{{ number_format($cf->cel, 1) }}</td>
                <td>{{ number_format($cf->export_tax, 1) }}</td>
                <td>{{ number_format($cf->wht_dividendes ?? 0, 1) }}</td>
                <td>{{ number_format($cf->business_license_tax ?? 0, 1) }}</td>
                <td style="font-weight:bold;">{{ number_format($te, 1) }}</td>
                <td>{{ $gt }}%</td>
            </tr>
        @endforeach
        <tr class="tot">
            <td>TOTAL</td>
            <td>{{ number_format($cashflows->sum('royalties'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('state_share'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('petrosen_share'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('income_tax'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('cel'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('export_tax'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('wht_dividendes'), 1) }}</td>
            <td>{{ number_format($cashflows->sum('business_license_tax'), 1) }}</td>
            <td>{{ number_format($totalState, 1) }}</td>
            <td>{{ $govTake }}%</td>
        </tr>
    </tbody>
</table>
</div>

<div class="footer">COS-PETROGAZ &bull; {{ $project->name }} &bull; Page 5/5</div>

</body>
</html>
