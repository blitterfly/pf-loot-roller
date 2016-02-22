<?php
function cost_weapon($entry, $double, $added_cost, $adjust = 1.0) {
    $enh_cost = $entry->enh * $entry->enh * 2000;
    if ($double) $enh_cost *= 2;
    return round($enh_cost * 4 * $adjust) + round($added_cost * 4 * $adjust) + $entry->cost;  // 4x innate item bonus
}

function roll_weapon($floor, $ceiling) {
    global $weapons_simple, $weapons_martial, $weapons_exotic, $weapons_firearms;
    global $weaponenh_melee, $weaponenh_ranged, $weaponenh_firearms, $weaponenh_ammo;
    global $weapon_materials;

weapon_do_over:
    $r = rand(1, 100);
    $is_firearm = false;
    if (inr($r, 1, 30)) $wep = arr($weapons_simple);
    else if (inr($r, 31, 70)) $wep = arr($weapons_martial);
    else if (inr($r, 71, 90)) {
        $wep = arr($weapons_firearms);
        $is_firearm = true;
    } else $wep = arr($weapons_exotic);

    $r = rand(1, 100);
    $mat = new NoMaterial();
    if ($wep->material !== None && $r > 69)
    {
        $mat = arr($weapon_materials);
        if ($mat->weapon_cost($wep) === MAT_INVALID)
            $mat = new NoMaterial();
    }

    $final = new ItemEntry();
    $mat_name = $mat->name();
    $final->desc = ($mat_name !== '' ? $mat_name . ' ' : '') . $wep->name;
    $final->cost = $wep->cost + $mat->weapon_cost($wep);
    if ($wep->is_ammo())
        $final->icon = 'ammo';
    else if ($is_firearm)
        $final->icon = 'gun';
    else if ($wep->type === Melee)
        $final->icon = 'melee';
    else
        $final->icon = 'ranged';

    $count = 0;
    $added_cost = 0;
    while ($count < 5 && (cost_weapon($final, $wep->double, $added_cost) < $floor || cost_weapon($final, $wep->double, $added_cost) < ($ceiling - $floor) / 2)) {
        if ($is_firearm)
            $enh = arr($weaponenh_firearms);
        else if ($wep->is_ammo())
            $enh = arr($weaponenh_ammo);
        else if ($wep->type === Melee)
            $enh = arr($weaponenh_melee);
        else
            $enh = arr($weaponenh_ranged);
        $count++;
        if ($enh->is_valid($wep) === FALSE || array_search($enh->name, $final->tags) !== FALSE)
            continue;
        if (($enh->enh + $final->enh) > 5)
            continue;
        $sub = $enh->subselect();
        $tag = $enh->name . ($sub !== '' ? ' (' . $sub . ') ' : '');
        $added_cost += $enh->cost;
        if ($wep->double)
            $added_cost += $enh->cost;
        $final->enh += $enh->enh;
        array_push($final->tags, $tag);
    }

    // special case for amulet of mighty fists
    if ($wep->name === 'amulet of mighty fists')
    {
        if ($final->enh === 0)
            goto weapon_do_over;
        $final->icon = 'amulet';
    }
    if (cost_weapon($final, $wep->double, $added_cost) > $ceiling * 1.10)
        goto weapon_do_over;

    if ($final->enh === 0)
        $final->enh = 1;
    if ($wep->is_ammo())
        $final->name = substr($wep->name, 0, strpos($wep->name, '(') - 1);
    else
        $final->name = weapon_name();
    $final->cost = cost_weapon($final, $wep->double, $added_cost, 0.10); // 10% cost campaign

    return $final;
}
?>