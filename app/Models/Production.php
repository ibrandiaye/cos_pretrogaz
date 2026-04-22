<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
{
    protected $fillable = [
        'project_id', 'year',
        'petrole_jour', 'gaz_domestique_jour', 'gnl_jour', 'gaz_combustible_pertes',
    ];

    // Constantes de conversion (du fichier Excel)
    const BOE_CONVERSION = 5.8;          // mmscf/mboe
    const LNG_CONVERSION = 142.008197;   // mmscfd/Mtpa
    const GAS_HEATING_LNG = 1006.873;    // mmbtu/mmscf (LNG)
    const GAS_HEATING_DOMGAS = 1065;     // mmbtu/mmscf (Domgas)
    const GAS_HEATING_MMBTU_T = 52.225;  // mmbtu/tonne

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    // ── Computed annual values ──

    /** Petrole/Condensat (mmbarils/an) */
    public function petroleAn(): float
    {
        return (float) $this->petrole_jour * 365 / 1000;
    }

    /** Gaz domestique (Tbtu/an) */
    public function gazDomestiqueTbtu(): float
    {
        return (float) $this->gaz_domestique_jour * 365 * self::GAS_HEATING_DOMGAS / 1e6;
    }

    /** GNL (MTPA) */
    public function gnlMtpa(): float
    {
        return (float) $this->gnl_jour / self::LNG_CONVERSION;
    }

    /** GNL (Tbtu/an) */
    public function gnlTbtu(): float
    {
        return (float) $this->gnl_jour * 365 * self::GAS_HEATING_LNG / 1e6;
    }

    /** Total Gaz naturel (mmscf/jour) */
    public function totalGazJour(): float
    {
        return (float) $this->gaz_domestique_jour + (float) $this->gnl_jour + (float) $this->gaz_combustible_pertes;
    }

    /** Total hydrocarbures equiv petrole (mbarils/jour) */
    public function totalEquivPetrole(): float
    {
        return (float) $this->petrole_jour + $this->totalGazJour() / self::BOE_CONVERSION;
    }

    /** Total equiv petrole hors combustible/pertes (mbarils/jour) */
    public function totalEquivPetroleHorsPertes(): float
    {
        $gazHorsPertes = (float) $this->gaz_domestique_jour + (float) $this->gnl_jour;
        return (float) $this->petrole_jour + $gazHorsPertes / self::BOE_CONVERSION;
    }

    // ── Values used by EconomicModelService ──

    /** Oil in Mbbl/year (for revenue calculation) */
    public function oilMbblYear(): float
    {
        return $this->petroleAn();
    }

    /** Gas domestic in Tbtu/year */
    public function gasTbtuYear(): float
    {
        return $this->gazDomestiqueTbtu();
    }

    /** GNL in MT/year */
    public function gnlMtYear(): float
    {
        return $this->gnlMtpa();
    }
}
