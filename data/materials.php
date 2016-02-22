<?php
const MAT_INVALID = -1;

abstract class Material
{
    abstract function name();
    
    abstract function armor_cost($armor);
    abstract function weapon_cost($weapon);
    
    protected function is_leather($armor)
    {
        return bit($armor->material, Hide) || strpos($armor->name, 'leather') !== FALSE;
    } 
}

class NoMaterial extends Material
{
    function name()
    {
        return '';
    }
    
    function armor_cost($armor)
    {
        return 0;
    }
    
    function weapon_cost($weapon)
    {
        return 0;
    }
}

class Adamantine extends Material
{
    function name()
    {
        return 'adamantine';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 4850;
            if ($armor->type === M)
                return 9850;
            return 14850;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 54 * $weapon->ammo_count();
            return 2700;
        }
        return MAT_INVALID;
    }
}

class Angelskin extends Material
{
    function name()
    {
        return 'angelskin';
    }
    
    function armor_cost($armor)
    {
        if ($armor->type === L)
            return 1000;
        if ($armor->type === M)
            return 2000;
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        return MAT_INVALID;
    }
}

class BloodCrystal extends Material
{
    function name()
    {
        return 'blood crystal';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->dmg, P) || bit($weapon->dmg, S))
        {
            if ($weapon->is_ammo())
                return 300; // HACK: ~10
            return 2000;
        }
        return MAT_INVALID;
    }
}

class ColdIron extends Material
{
    function name()
    {
        return 'cold iron';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
            return $weapon->base_cost() * 2;
        return MAT_INVALID;
    }
}

class Darkleaf extends Material
{
    function name()
    {
        return 'darkleaf cloth';
    }
    
    function armor_cost($armor)
    {
        if ($this->is_leather($armor))
        {
            if ($armor->type === L)
                return 750;
            else if ($armor->type === M)
                return 1500;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        return MAT_INVALID;
    }
}

class Darkwood extends Material
{
    function name()
    {
        return 'darkwood';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Wood))
        {
            return 200; // HACK: ~20 lbs
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Wood))
        {
            if ($weapon->is_ammo())
                return 10;
            return 50; // HACK: just estimating ~5 lbs, don't feel like doing per weapon
        }
        return MAT_INVALID;
    }
}

class Dragonhide extends Material
{
    function name()
    {
        return 'dragonhide';
    }
    
    function armor_cost($armor)
    {
        return $armor->cost;
    }
    
    function weapon_cost($weapon)
    {
        return MAT_INVALID;
    }
}

class Dragonskin extends Material
{
    function name()
    {
        return 'dragonskin grip';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        return 250;
    }
}

class EelHide extends Material
{
    function name()
    {
        return 'eel hide';
    }
    
    function armor_cost($armor)
    {
        if ($this->is_leather($armor))
        {
            if ($armor->type === L)
                return 1200;
            else if ($armor->type === M)
                return 1800;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        return MAT_INVALID;
    }
}

class ElysianBronze extends Material
{
    function name()
    {
        return 'elysian bronze';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 1000;
            else if ($armor->type === M)
                return 2000;
            return 3000;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 200; // HACK: ~10
            return 1000;
        }
        return MAT_INVALID;
    }
}

class Fireforged
{
    function name()
    {
        return 'fire-forged steel';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 850;
            else if ($armor->type === M)
                return 2350;
            return 2850;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 150; // HACK: ~10
            return 300;
        }
        return MAT_INVALID;
    }
}

class Frostforged
{
    function name()
    {
        return 'frost-forged steel';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 850;
            else if ($armor->type === M)
                return 2350;
            return 2850;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 150; // HACK: ~10
            return 300;
        }
        return MAT_INVALID;
    }
}

class Greenwood extends Material
{
    function name()
    {
        return 'greenwood';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Wood))
        {
            return 1000; // HACK: ~20 lbs
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Wood))
        {
            return 300; // HACK: ~6 lbs
        }
        return MAT_INVALID;
    }
}

class Griffonmane extends Material
{
    function name()
    {
        return 'griffonmane';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal) === FALSE)
        {
            return 200;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        return MAT_INVALID;
    }
}

class Horacalcum extends Material
{
    function name()
    {
        return 'horacalcum';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 10000;
            if ($armor->type === M)
                return 30000;
            return 60000;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            return 6000;
        }
        return MAT_INVALID;
    }
}

class Inubrix extends Material
{
    function name()
    {
        return 'inubrix';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
            return 5000;
        return MAT_INVALID;
    }
}

class LivingSteel extends Material
{
    function name()
    {
        return 'living steel';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 500;
            else if ($armor->type === M)
                return 1000;
            return 1500;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 100; // HACK: ~10
            return 500;
        }
        return MAT_INVALID;
    }
}

class Mithral extends Material
{
    function name()
    {
        return 'mithral';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 850;
            if ($armor->type === M)
                return 3850;
            return 8850;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 500;
            return 2500; // HACK: just estimating ~5 lbs, don't feel like doing per weapon
        }
    }
}

class Noqual extends Material
{
    function name()
    {
        return 'noqual';
    }
    
    function armor_cost($armor)
    {
        if (bit($armor->material, Metal))
        {
            if ($armor->type === L)
                return 4000;
            if ($armor->type === M)
                return 8000;
            return 12000;
        }
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            return 500;
        }
        return MAT_INVALID;
    }
}

class Silver extends Material
{
    function name()
    {
        return 'silver';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            if ($weapon->is_ammo())
                return 2;
            // HACK: more estimation, using 2h cost for double weapons
            if ($weapon->double)
                return 180;
            // HACK: low cost items using light cost
            if ($weapon->base_cost() < 10)
                return 20;
            return 90;
        }
        return MAT_INVALID;
    }
}

class Viridium extends Material
{
    function name()
    {
        return 'viridium';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Metal))
        {
            return 200; // HACK: for ammo, ~10
        }
        return MAT_INVALID;
    }
}

class Whipwood extends Material
{
    function name()
    {
        return 'whipwood';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Wood))
        {
            return 500;
        }
        return MAT_INVALID;
    }
}

class Wyroot extends Material
{
    protected $ki;
    
    function __construct($ki = 1)
    {
        $this->ki = $ki;
    }
    
    function name()
    {
        return 'wyroot (' . $this->ki . ' point)';
    }
    
    function armor_cost($armor)
    {
        return MAT_INVALID;
    }
    
    function weapon_cost($weapon)
    {
        if (bit($weapon->material, Wood))
        {
            if ($this->ki === 1)
                return 1000;
            else if ($this->ki === 2)
                return 2000;
            return 4000;
        }
        return MAT_INVALID;
    }
}

$armor_materials = [
    new Adamantine(),
    new Angelskin(),
    new Darkleaf(),
    new Darkwood(),
    new Dragonhide(),
    new EelHide(),
    new ElysianBronze(),
    new Fireforged(),
    new Frostforged(),
    new Greenwood(),
    new Griffonmane(),
    new Horacalcum(),
    new LivingSteel(),
    new Mithral(),
    new Noqual()
];

$weapon_materials = [
    new Adamantine(),
    new BloodCrystal(),
    new ColdIron(),
    new Darkwood(),
    new Dragonskin(),
    new ElysianBronze(),
    new Fireforged(),
    new Frostforged(),
    new Greenwood(),
    new Horacalcum(),
    new Inubrix(),
    new LivingSteel(),
    new Mithral(),
    new Noqual(),
    new Silver(),
    new Viridium(),
    new Whipwood(),
    new Wyroot(),
    new Wyroot(2),
    new Wyroot(3)
];
?>