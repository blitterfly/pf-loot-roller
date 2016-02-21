<?php
abstract class Material
{
    abstract function name();
    
    abstract function armor_cost($armor);
    abstract function weapon_cost($weapon);    
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
        if ($armor->type === L)
            return 4850;
        if ($armor->type === M)
            return 9850;
        return 14850;
    }
    
    function weapon_cost($weapon)
    {
        if ($weapon->is_ammo())
            return 54 * $weapon->ammo_count();
        return 2700;
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
        die('wot');
    }
    
    function weapon_cost($weapon)
    {
        return $weapon->base_cost() * 2;
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
        // TODO
        return 0;
    }
    
    function weapon_cost($weapon)
    {
        if ($weapon->is_ammo())
            return 10;
        return 50; // HACK: just estimating ~5 lbs, don't feel like doing per weapon
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
        die('wot');
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
        if ($armor->type === L)
            return 850;
        if ($armor->type === M)
            return 3850;
        return 8850;
    }
    
    function weapon_cost($weapon)
    {
        if ($weapon->is_ammo())
            return 500;
        return 2500; // HACK: just estimating ~5 lbs, don't feel like doing per weapon
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
        die('wot');
    }
    
    function weapon_cost($weapon)
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
}
?>