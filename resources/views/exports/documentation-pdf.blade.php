<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>COS-PETROGAZ - Documentation Technique des Calculs</title>
    <style>
        @page { margin: 18mm 15mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 9pt; color: #1a1a2e; line-height: 1.55; }

        /* Cover */
        .cover { background: #0a1628; color: #fff; margin: -18mm -15mm; padding: 80px 50px 50px 50px; min-height: 820px; position: relative; }
        .cover .brand { font-size: 8pt; color: #64ffda; text-transform: uppercase; letter-spacing: 4px; font-weight: bold; }
        .cover h1 { font-size: 28pt; margin: 15px 0 5px 0; font-weight: bold; line-height: 1.15; }
        .cover .subtitle { font-size: 14pt; color: #8892b0; margin-bottom: 8px; }
        .cover .version { font-size: 10pt; color: #4a5568; margin-top: 30px; }
        .cover .divider { width: 60px; height: 3px; background: #4361ee; margin: 25px 0; border-radius: 2px; }
        .cover .info td { padding: 5px 0; font-size: 9pt; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .cover .info .lbl { color: #64748b; width: 180px; }
        .cover .info .val { color: #e2e8f0; font-weight: bold; }
        .cover .circle1 { position: absolute; right: -60px; top: -60px; width: 250px; height: 250px; background: rgba(67,97,238,0.08); border-radius: 50%; }
        .cover .circle2 { position: absolute; right: 80px; bottom: 120px; width: 150px; height: 150px; background: rgba(100,255,218,0.05); border-radius: 50%; }

        /* Headings */
        h2 { font-size: 14pt; color: #0a1628; margin: 18px 0 8px 0; padding-bottom: 4px; border-bottom: 2px solid #4361ee; }
        h3 { font-size: 11pt; color: #4361ee; margin: 12px 0 6px 0; }
        h4 { font-size: 9.5pt; color: #6c5ce7; margin: 8px 0 4px 0; }

        /* Formula boxes */
        .formula { background: #f0f4ff; border-left: 3px solid #4361ee; padding: 8px 12px; margin: 6px 0; font-family: DejaVu Sans Mono, monospace; font-size: 8pt; line-height: 1.6; }
        .formula-title { font-size: 6.5pt; font-weight: bold; text-transform: uppercase; letter-spacing: 0.8px; color: #4361ee; margin-bottom: 3px; }

        /* Notes */
        .note { background: #fffbeb; border-left: 3px solid #f59e0b; padding: 6px 10px; margin: 6px 0; font-size: 8pt; }
        .note-title { font-size: 6.5pt; font-weight: bold; text-transform: uppercase; color: #f59e0b; }
        .important { background: #fef2f2; border-left: 3px solid #ef4444; padding: 6px 10px; margin: 6px 0; font-size: 8pt; }
        .new-tag { background: #dcfce7; color: #166534; padding: 1px 6px; border-radius: 3px; font-size: 6.5pt; font-weight: bold; text-transform: uppercase; }

        /* Tables */
        .doc-table { width: 100%; border-collapse: collapse; font-size: 8pt; margin: 6px 0; }
        .doc-table th { background: #0a1628; color: #fff; padding: 5px 6px; text-align: left; font-size: 7pt; font-weight: bold; text-transform: uppercase; }
        .doc-table td { padding: 4px 6px; border-bottom: 1px solid #edf2f7; }
        .doc-table tr:nth-child(even) td { background: #f7fafc; }
        .doc-table .highlight { background: #f0f4ff; }

        /* TOC */
        .toc { margin: 15px 0; }
        .toc-item { padding: 3px 0; border-bottom: 1px dotted #e2e8f0; font-size: 9pt; }
        .toc-num { color: #4361ee; font-weight: bold; display: inline-block; width: 25px; }

        .page-break { page-break-before: always; }
        .footer { text-align: center; font-size: 7pt; color: #a0aec0; margin-top: 10px; padding-top: 5px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>

{{-- ════════════════════════════════ --}}
{{-- COVER PAGE                       --}}
{{-- ════════════════════════════════ --}}
<div class="cover">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="brand">COS-PETROGAZ</div>
    <h1>Documentation Technique<br/>des Calculs</h1>
    <div class="subtitle">Modele Economique Petrolier</div>
    <div class="subtitle" style="font-size:11pt;">Codes Petroliers du Senegal (1998 & 2019)</div>
    <div class="divider"></div>
    <table class="info" style="width:auto; border-collapse:collapse;">
        <tr><td class="lbl">Date</td><td class="val">Avril 2026</td></tr>
        <tr><td class="lbl">Base legale</td><td class="val">Code Petrolier 1998 (CRPP & JOA) / Code Petrolier 2019 (CPP & JOA)</td></tr>
    </table>
</div>

{{-- ════════════════════════════════ --}}
{{-- TABLE OF CONTENTS                --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>Table des Matieres</h2>
<div class="toc">
    <div class="toc-item"><span class="toc-num">1.</span> Vue d'ensemble du modele</div>
    <div class="toc-item"><span class="toc-num">2.</span> Parametres d'entree </div>
    <div class="toc-item"><span class="toc-num">3.</span> Etape 1 - Calcul des revenus bruts </div>
    <div class="toc-item"><span class="toc-num">4.</span> Etape 2 - Redevances (Royalties)</div>
    <div class="toc-item"><span class="toc-num">5.</span> Etape 3 - Taxes avant recouvrement des couts</div>
    <div class="toc-item"><span class="toc-num">6.</span> Etape 4 - Amortissement fiscal </div>
    <div class="toc-item"><span class="toc-num">7.</span> Etape 5 - Recouvrement des couts (Cost Recovery) </div>
    <div class="toc-item"><span class="toc-num">8.</span> Etape 6 - Profit Oil</div>
    <div class="toc-item"><span class="toc-num">9.</span> Etape 7 - R-Factor (Code 2019)</div>
    <div class="toc-item"><span class="toc-num">10.</span> Etape 8 - Partage du Profit Oil</div>
    <div class="toc-item"><span class="toc-num">11.</span> Etape 9 - Impot sur les Societes (IS)</div>
    <div class="toc-item"><span class="toc-num">12.</span> Etape 10 - WHT et BLT</div>
    <div class="toc-item"><span class="toc-num">13.</span> Etape 11 - Financement PETROSEN</div>
    <div class="toc-item"><span class="toc-num">14.</span> Etape 12 - Cashflow du projet </div>
    <div class="toc-item"><span class="toc-num">15.</span> Etape 13 - VAN et TRI</div>
    <div class="toc-item"><span class="toc-num">16.</span> Calcul de l'inflation (CAPEX/OPEX/ABEX) </div>
    <div class="toc-item"><span class="toc-num">17.</span> Conversion de production </div>
    <div class="toc-item"><span class="toc-num">18.</span> Analyse de scenarios</div>
    <div class="toc-item"><span class="toc-num">19.</span> Tableaux recapitulatifs</div>
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 1 : VUE D'ENSEMBLE      --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>1. Vue d'ensemble du modele</h2>
<p>Le modele economique COS-PETROGAZ simule l'ensemble du cycle fiscal d'un projet petrolier au Senegal, depuis les revenus bruts de production jusqu'au cashflow net de l'operateur.</p>

<h3>Flux de calcul global</h3>
<div class="formula">
<div class="formula-title">Pipeline de calcul</div>
Production (taux journaliers) → Conversion annuelle → Revenus Bruts<br/>
→ Redevances & Taxes → Revenu Net → Cost Recovery (incl. ABEX)<br/>
→ Profit Oil → Partage Etat/Contractant → IS + WHT + BLT<br/>
→ Cashflow Projet → VAN & TRI
</div>

<p>Le modele supporte deux regimes juridiques :</p>
<ul>
    <li><strong>Code Petrolier 1998</strong> (CRPP & JOA) - Partage base sur la production journaliere</li>
    <li><strong>Code Petrolier 2019</strong> (CPP & JOA) - Partage base sur le R-Factor</li>
</ul>

{{-- ════════════════════════════════ --}}
{{-- SECTION 2 : PARAMETRES           --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>2. Parametres d'entree </h2>

<h3>2.1 CAPEX - Investissements detailles </h3>
<table class="doc-table">
    <tr><th>Champ</th><th>Unite</th><th>Description</th><th>Amortissement</th></tr>
    <tr><td>Exploration</td><td>M$</td><td>Couts d'exploration et sismique</td><td>1 an</td></tr>
    <tr><td>Etudes Pre-FID</td><td>M$</td><td>Etudes de faisabilite avant decision finale d'investissement</td><td>1 an</td></tr>
    <tr><td>Forage & Completion</td><td>M$</td><td>Forage et completion des puits de developpement</td><td>5 ans</td></tr>
    <tr><td>Installations Sous-Marines</td><td>M$</td><td>Equipements et structures sous-marines</td><td>5 ans</td></tr>
    <tr><td>Pipeline(s)</td><td>M$</td><td>Pipeline d'evacuation</td><td>10 ans</td></tr>
    <tr><td>Installations de Surface</td><td>M$</td><td>Plateforme, FPSO, installations de traitement</td><td>5 ans</td></tr>
    <tr><td>Owners Cost</td><td>M$</td><td>Couts de supervision et gestion du proprietaire</td><td>5 ans</td></tr>
    <tr><td>Imprevus</td><td>M$</td><td>Contingences et imprevus</td><td>5 ans</td></tr>
</table>

<h3>2.2 OPEX - Couts operationnels detailles </h3>
<table class="doc-table">
    <tr><th>Champ</th><th>Unite</th><th>Description</th></tr>
    <tr><td>Location FLNG</td><td>M$</td><td>Location de l'unite flottante de liquefaction (GNL)</td></tr>
    <tr><td>Location FPSO</td><td>M$</td><td>Location de la plateforme flottante de production/stockage</td></tr>
    <tr><td>Opex Puits</td><td>M$</td><td>Couts d'intervention et workover sur les puits</td></tr>
    <tr><td>Maintenance Installations</td><td>M$</td><td>Maintenance des installations de surface et sous-marines</td></tr>
    <tr><td>Autres Opex</td><td>M$</td><td>Autres couts operationnels (logistique, personnel, assurance)</td></tr>
</table>

<h3>2.3 ABEX - Couts d'abandon </h3>
<table class="doc-table">
    <tr><th>Champ</th><th>Unite</th><th>Description</th></tr>
    <tr><td>Cout Abandon</td><td>M$</td><td>Provision pour demantelement et rehabilitation du site en fin de vie</td></tr>
</table>

<h3>2.4 Production - Taux journaliers </h3>
<table class="doc-table">
    <tr><th>Champ (saisie)</th><th>Unite</th><th>Description</th></tr>
    <tr><td>Petrole/Condensat</td><td>mbaril/jour</td><td>Milliers de barils par jour</td></tr>
    <tr><td>Gaz Domestique</td><td>mmscf/jour</td><td>Millions de pieds cubes standard par jour</td></tr>
    <tr><td>GNL</td><td>mmscf/jour</td><td>Millions de pieds cubes standard par jour (avant liquefaction)</td></tr>
    <tr><td>Gaz Combustible/Pertes</td><td>mmscf/jour</td><td>Gaz utilise comme combustible et pertes</td></tr>
</table>

<h3>2.5 Prix Macro-economiques</h3>
<table class="doc-table">
    <tr><th>Champ</th><th>Unite</th><th>Description</th></tr>
    <tr><td>Prix Petrole (Brent)</td><td>$/bbl</td><td>Prix de reference du baril</td></tr>
    <tr><td>Prix Gaz</td><td>$/MMBTU</td><td>Prix du gaz naturel domestique</td></tr>
    <tr><td>Prix GNL</td><td>$/MMBTU</td><td>Prix du GNL a l'export</td></tr>
    <tr><td>Inflation</td><td>%</td><td>Taux d'inflation annuel (utilise pour calcul inflation CAPEX/OPEX/ABEX)</td></tr>
    <tr><td>Taux de change</td><td>FCFA/USD</td><td>Taux de change franc CFA / dollar</td></tr>
</table>

<h3>2.6 Parametres fiscaux et contractuels</h3>
<table class="doc-table">
    <tr><th>Parametre</th><th>Code 1998</th><th>Code 2019</th><th>Unite</th></tr>
    <tr><td>Impot sur les Societes (IS)</td><td>30%</td><td>30%</td><td>%</td></tr>
    <tr><td>CEL</td><td>1%</td><td>1%</td><td>% du revenu brut</td></tr>
    <tr><td>Taxe Export</td><td>0%</td><td>1%</td><td>% du revenu brut</td></tr>
    <tr><td>WHT Dividendes</td><td>5%</td><td>5%</td><td>% du cashflow net</td></tr>
    <tr><td>Business License Tax</td><td>0.02%</td><td>0.02%</td><td>% du revenu brut</td></tr>
    <tr><td>Redevance Petrole</td><td>10%</td><td>7-10% *</td><td>% du revenu petrole</td></tr>
    <tr><td>Redevance Gaz</td><td>5%</td><td>6%</td><td>% du revenu gaz</td></tr>
    <tr><td>Plafond Cost Recovery</td><td>75%</td><td>55-70% *</td><td>% du revenu net</td></tr>
    <tr><td>Participation PETROSEN</td><td>10%</td><td>10%</td><td>% de la part contractant</td></tr>
    <tr><td>Amort. Exploration</td><td>1 an</td><td>1 an</td><td>annees</td></tr>
    <tr><td>Amort. Installations</td><td>5 ans</td><td>5 ans</td><td>annees</td></tr>
    <tr><td>Amort. Pipeline/FPSO</td><td>10 ans</td><td>10 ans</td><td>annees</td></tr>
    <tr><td>Report de pertes (NOL)</td><td>3 ans</td><td>3 ans</td><td>annees</td></tr>
</table>

{{-- ════════════════════════════════ --}}
{{-- SECTION 3 : REVENUS BRUTS       --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>3. Etape 1 - Calcul des Revenus Bruts </h2>
<p>Les revenus sont calcules a partir des taux journaliers convertis en valeurs annuelles.</p>

<h3>3.1 Conversion Production (voir Section 17 pour le detail)</h3>
<div class="formula">
<div class="formula-title">Conversions journalier → annuel</div>
Petrole_An (mmbbls/an) = petrole_jour (mbaril/j) x 365 / 1000<br/>
Gaz_Dom_Tbtu (Tbtu/an) = gaz_domestique_jour (mmscf/j) x 365 x 1065 / 10^6<br/>
GNL_MT (MTPA) = gnl_jour (mmscf/j) / 142.008
</div>

<h3>3.2 Revenu Petrole</h3>
<div class="formula">
<div class="formula-title">Formule</div>
Revenu_Petrole = Petrole_An (mmbbls/an) x Prix_Oil ($/bbl)
</div>

<h3>3.3 Revenu Gaz Domestique</h3>
<div class="formula">
<div class="formula-title">Formule</div>
Revenu_Gaz = Gaz_Dom_Tbtu (Tbtu/an) x Prix_Gas ($/MMBTU)<br/>
<br/>
Justification : 1 Tbtu = 10^6 MMBTU, donc Tbtu x $/MMBTU = M$
</div>

<h3>3.4 Revenu GNL</h3>
<div class="formula">
<div class="formula-title">Formule</div>
Revenu_GNL = GNL_MT (MTPA) x Prix_GNL ($/MMBTU) x 52.225<br/>
<br/>
Facteur 52.225 : Gas heating value (MMBTU par tonne de GNL) - fichier Excel de reference
</div>

<h3>3.5 Revenu Brut Total</h3>
<div class="formula">
<div class="formula-title">Formule</div>
Revenu_Brut = Revenu_Petrole + Revenu_Gaz + Revenu_GNL
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTIONS 4-5 : REDEVANCES/TAXES --}}
{{-- ════════════════════════════════ --}}
<h2>4. Etape 2 - Redevances (Royalties)</h2>

<h3>4.1 Code 2019 - Taux differencies par type de bloc</h3>
<table class="doc-table">
    <tr><th>Type de Bloc</th><th>Redevance Liquides</th><th>Redevance Gaz</th></tr>
    <tr><td>Onshore</td><td>10%</td><td>6%</td></tr>
    <tr><td>Offshore Peu Profond</td><td>9%</td><td>6%</td></tr>
    <tr><td>Offshore Profond</td><td>8%</td><td>6%</td></tr>
    <tr><td>Offshore Ultra Profond</td><td>7%</td><td>6%</td></tr>
</table>

<h3>4.2 Code 1998</h3>
<p>Hydrocarbures liquides : 10% &bull; Hydrocarbures gazeux : 5%</p>

<div class="formula">
<div class="formula-title">Formules</div>
Redevance_Petrole = Revenu_Petrole x Taux_Redevance_Petrole<br/>
Redevance_Gaz = (Revenu_Gaz + Revenu_GNL) x Taux_Redevance_Gaz<br/>
Redevances_Totales = Redevance_Petrole + Redevance_Gaz
</div>

<h2>5. Etape 3 - Taxes avant recouvrement des couts</h2>
<div class="formula">
<div class="formula-title">Formules</div>
Taxe_Export = Revenu_Brut x 1% (Code 2019 uniquement)<br/>
CEL = Revenu_Brut x 1%<br/>
BLT = Revenu_Brut x 0.02%<br/>
Revenu_Net = Revenu_Brut - Redevances_Totales - Taxe_Export
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 6 : AMORTISSEMENT        --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>6. Etape 4 - Amortissement Fiscal </h2>

<h3>6.1 Mapping des categories CAPEX vers les durees d'amortissement</h3>
<table class="doc-table">
    <tr><th>Categorie d'amortissement</th><th>Champs CAPEX concernes</th><th>Duree</th><th>Methode</th></tr>
    <tr class="highlight"><td>Exploration</td><td>Exploration + Etudes Pre-FID</td><td>1 an</td><td>Lineaire</td></tr>
    <tr><td>Installations</td><td>Forage & Completion + Inst. Sous-Marines + Inst. Surface + Owners Cost + Imprevus</td><td>5 ans</td><td>Lineaire</td></tr>
    <tr class="highlight"><td>Pipeline / FPSO</td><td>Pipeline(s)</td><td>10 ans</td><td>Lineaire</td></tr>
    <tr><td>ABEX</td><td>Cout Abandon</td><td>1 an</td><td>Immediat</td></tr>
</table>


<div class="formula">
<div class="formula-title">Formule d'amortissement annuel</div>
Amortissement_annuel(y) = Somme [ Montant_actif / Duree_actif ]<br/>
pour chaque actif ou : annee_debut &le; y &lt; annee_debut + duree
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 7 : COST RECOVERY        --}}
{{-- ════════════════════════════════ --}}
<h2>7. Etape 5 - Recouvrement des Couts </h2>

<h3>7.1 Plafonds</h3>
<table class="doc-table">
    <tr><th>Code 2019 - Type de Bloc</th><th>Plafond</th></tr>
    <tr><td>Onshore</td><td>55%</td></tr>
    <tr><td>Offshore Peu Profond</td><td>60%</td></tr>
    <tr><td>Offshore Profond</td><td>65%</td></tr>
    <tr><td>Offshore Ultra Profond</td><td>70%</td></tr>
</table>
<p>Code 1998 : plafond unique de 75%.</p>

<div class="formula">
<div class="formula-title">Formules</div>
Couts_Annee(y) = CAPEX_Total(y) + OPEX_Total(y) + ABEX_Total(y)<br/>
Couts_Cumules(y) = Couts_Cumules(y-1) + Couts_Annee(y)<br/>
Plafond_CR = Revenu_Net x Taux_Plafond<br/>
Cost_Recovery = MIN( Couts_Cumules, MAX(0, Plafond_CR) )<br/>
Couts_Cumules(y) = Couts_Cumules(y) - Cost_Recovery
</div>


{{-- ════════════════════════════════ --}}
{{-- SECTIONS 8-10 : PROFIT OIL       --}}
{{-- ════════════════════════════════ --}}
<h2>8. Etape 6 - Profit Oil</h2>
<div class="formula">
<div class="formula-title">Formule</div>
Profit_Oil = MAX(0, Revenu_Net - Cost_Recovery)
</div>

<h2>9. Etape 7 - R-Factor (Code 2019)</h2>
<div class="formula">
<div class="formula-title">Formule</div>
Revenus_Cumules(y) += Revenu_Brut(y)<br/>
Couts_Totaux_Cumules = Couts_Non_Recouvres + Cost_Recovery_Cumul<br/>
R_Factor = Revenus_Cumules / Couts_Totaux_Cumules
</div>

<h2>10. Etape 8 - Partage du Profit Oil</h2>
<h3>10.1 Code 2019 - Tranches R-Factor</h3>
<table class="doc-table">
    <tr><th>R-Factor</th><th>Part Etat</th><th>Part Contractant</th></tr>
    <tr><td>R &lt; 1.0</td><td>40%</td><td>60%</td></tr>
    <tr><td>1.0 &le; R &lt; 2.0</td><td>45%</td><td>55%</td></tr>
    <tr><td>2.0 &le; R &lt; 3.0</td><td>55%</td><td>45%</td></tr>
    <tr><td>R &ge; 3.0</td><td>60%</td><td>40%</td></tr>
</table>

<h3>10.2 Code 1998 - Tranches de Production</h3>
<table class="doc-table">
    <tr><th>Production (bbl/jour)</th><th>Part Etat</th><th>Part Contractant</th></tr>
    <tr><td>&lt; 25 000</td><td>40%</td><td>60%</td></tr>
    <tr><td>25 000 - 50 000</td><td>45%</td><td>55%</td></tr>
    <tr><td>50 000 - 75 000</td><td>50%</td><td>50%</td></tr>
    <tr><td>75 000 - 100 000</td><td>55%</td><td>45%</td></tr>
    <tr><td>&ge; 100 000</td><td>60%</td><td>40%</td></tr>
</table>

<div class="formula">
<div class="formula-title">Repartition part contractant</div>
Part_PETROSEN = Part_Contractant x Taux_Participation_PETROSEN<br/>
Part_Operateur = Part_Contractant x (1 - Taux_Participation_PETROSEN)<br/>
Part_Etat_Totale = Part_Etat_PO + (Carried_Interest x Revenu_Brut)
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTIONS 11-13 : IS/WHT/PETROSEN --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>11. Etape 9 - Impot sur les Societes (IS)</h2>
<div class="formula">
<div class="formula-title">Formules</div>
Revenu_Imposable = Part_Operateur - Amortissement_Annuel<br/>
(Application du report de pertes NOL si negatif - max 3 ans)<br/>
IS = MAX(0, Revenu_Imposable) x 30%<br/>
Part_Operateur_Nette = Part_Operateur - IS
</div>

<h2>12. Etape 10 - WHT et BLT</h2>
<div class="formula">
<div class="formula-title">Formules</div>
WHT = MAX(0, Part_Operateur_Nette) x 5%<br/>
BLT = Revenu_Brut x 0.02%  (calcule en Etape 3)
</div>

<h2>13. Etape 11 - Financement PETROSEN</h2>
<div class="formula">
<div class="formula-title">Pendant la periode de grace (y &le; grace)</div>
Interets = Solde x Taux_Interet<br/>
Interets_Capitalises += Interets
</div>
<div class="formula">
<div class="formula-title">Apres la periode de grace (y &gt; grace)</div>
Interets = Solde x Taux_Interet<br/>
Principal = Montant_Emprunt / (Maturite - Grace)<br/>
Solde -= MIN(Principal, Solde_Restant)
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 14 : CASHFLOW             --}}
{{-- ════════════════════════════════ --}}
<h2>14. Etape 12 - Cashflow du Projet </h2>
<div class="formula">
<div class="formula-title">Formule (perspective operateur)</div>
Cashflow_Projet(y) = Part_Operateur_Nette - WHT<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- CAPEX_Total - ABEX_Total<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- OPEX_Total x (1 - Part_PETROSEN)
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 15 : VAN/TRI             --}}
{{-- ════════════════════════════════ --}}
<h2>15. Etape 13 - VAN et TRI</h2>
<div class="formula">
<div class="formula-title">VAN (Valeur Actuelle Nette)</div>
VAN = Somme(y=1..N) [ Cashflow_Projet(y) / (1 + r)^y ]<br/>
ou r = taux d'actualisation (defaut 10%)
</div>
<div class="formula">
<div class="formula-title">TRI (Taux de Rendement Interne) - Methode de bisection</div>
Trouver r tel que VAN(r) = 0<br/>
Bornes : low = -99%, high = 1000%, tolerance = 0.0001, max 1000 iterations
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 16 : INFLATION            --}}
{{-- ════════════════════════════════ --}}
<div class="page-break"></div>
<h2>16. Calcul de l'inflation (CAPEX/OPEX/ABEX) </h2>
<p>Chaque onglet CAPEX, OPEX et ABEX affiche 3 colonnes calculees automatiquement a partir du taux d'inflation defini dans l'onglet Macro/Prix.</p>

<div class="formula">
<div class="formula-title">Formules</div>
Taux_Inflation(y) = Prix.inflation(y) / 100<br/>
Total_Hors_Inflation(y) = Somme des colonnes de saisie<br/>
Montant_Inflation(y) = Total_Hors_Inflation(y) x Taux_Inflation(y)<br/>
Total_Avec_Inflation(y) = Total_Hors_Inflation(y) + Montant_Inflation(y)
</div>

<div class="note">
    <div class="note-title">Note</div>
    Ces calculs sont affiches dans l'interface en temps reel (Alpine.js) et dans les exports. Le modele economique utilise les montants hors inflation pour les calculs de cost recovery et cashflow.
</div>

{{-- ════════════════════════════════ --}}
{{-- SECTION 17 : CONVERSION PROD     --}}
{{-- ════════════════════════════════ --}}
<h2>17. Conversion de Production </h2>
<p>La saisie se fait en taux journaliers. 7 colonnes annuelles sont calculees automatiquement.</p>

<h3>17.1 Constantes de conversion (fichier Excel de reference)</h3>
<table class="doc-table">
    <tr><th>Constante</th><th>Valeur</th><th>Unite</th></tr>
    <tr><td>BOE Conversion</td><td>5.8</td><td>mmscf/mboe</td></tr>
    <tr><td>LNG Conversion Rate</td><td>142.008</td><td>mmscfd/Mtpa</td></tr>
    <tr><td>Gas Heating Value (LNG)</td><td>1 006.873</td><td>MMBTU/mmscf</td></tr>
    <tr><td>Gas Heating Value (Domgas)</td><td>1 065</td><td>MMBTU/mmscf</td></tr>
    <tr><td>Gas Heating Value</td><td>52.225</td><td>MMBTU/tonne</td></tr>
</table>

<h3>17.2 Colonnes calculees</h3>
<table class="doc-table">
    <tr><th>Colonne</th><th>Unite</th><th>Formule</th></tr>
    <tr><td>Petrole (mmbbls/an)</td><td>mmbbls/an</td><td>petrole_jour x 365 / 1000</td></tr>
    <tr><td>Gaz Dom. (Tbtu/an)</td><td>Tbtu/an</td><td>gaz_dom_jour x 365 x 1065 / 10^6</td></tr>
    <tr><td>GNL (MTPA)</td><td>MT/an</td><td>gnl_jour / 142.008</td></tr>
    <tr><td>GNL (Tbtu/an)</td><td>Tbtu/an</td><td>gnl_jour x 365 x 1006.873 / 10^6</td></tr>
    <tr><td>Total Gaz (mmscf/j)</td><td>mmscf/j</td><td>gaz_dom + gnl + combustible_pertes</td></tr>
    <tr><td>Equiv. Petrole (mboe/j)</td><td>mboe/j</td><td>petrole + total_gaz / 5.8</td></tr>
    <tr><td>Equiv. hors pertes (mboe/j)</td><td>mboe/j</td><td>petrole + (gaz_dom + gnl) / 5.8</td></tr>
</table>

{{-- ════════════════════════════════ --}}
{{-- SECTION 18 : SCENARIOS            --}}
{{-- ════════════════════════════════ --}}
<h2>18. Analyse de Scenarios</h2>
<table class="doc-table">
    <tr><th>Scenario</th><th>Mult. Prix Petrole</th><th>Mult. Prix Gaz</th><th>Mult. Production</th></tr>
    <tr><td>Base</td><td>x 1.0</td><td>x 1.0</td><td>x 1.0</td></tr>
    <tr><td>Prix Bas</td><td>x 0.7</td><td>x 0.8</td><td>x 1.0</td></tr>
    <tr><td>Prix Haut</td><td>x 1.3</td><td>x 1.3</td><td>x 1.0</td></tr>
    <tr><td>Production Basse</td><td>x 1.0</td><td>x 1.0</td><td>x 0.7</td></tr>
    <tr><td>Production Haute</td><td>x 1.0</td><td>x 1.0</td><td>x 1.3</td></tr>
</table>

{{-- ════════════════════════════════ --}}
{{-- SECTION 19 : RECAPITULATIF       --}}
{{-- ════════════════════════════════ --}}
<h2>19. Tableaux Recapitulatifs</h2>

<h3>19.1 Government Take</h3>
<div class="formula">
<div class="formula-title">Formule</div>
Government_Take (%) = Total_Revenus_Etat / Revenu_Brut_Total x 100<br/>
<br/>
Total_Revenus_Etat = Redevances + Part_Etat_PO + PETROSEN + IS + CEL + Taxe_Export + WHT + BLT
</div>

<h3>19.2 Indicateurs avances (Export PDF)</h3>
<table class="doc-table">
    <tr><th>Indicateur</th><th>Formule</th></tr>
    <tr><td>Payback Year</td><td>Premiere annee ou le cashflow cumule devient positif</td></tr>
    <tr><td>Indice de Profitabilite</td><td>VAN / CAPEX_Total</td></tr>
    <tr><td>Pic de Production</td><td>Annee avec le plus haut equivalent petrole (mboe/j)</td></tr>
</table>

<div class="footer" style="margin-top:30px;">
    COS-PETROGAZ - Documentation Technique des Calculs - Avril 2026<br/>
    Codes Petroliers du Senegal (1998 &amp; 2019)
</div>

</body>
</html>
