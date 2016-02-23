<?php
function cost_armor($entry, $added_cost = 0, $adjust = 1.0) {
    $enh_cost = $entry->enh * $entry->enh * 1000;
    return round($enh_cost * 4 * $adjust) + round($added_cost * 4 * $adjust) + $entry->cost; // 4x innate item bonus
}

function roll_armor($floor, $ceiling)
{
    global $armors, $armorenh, $shields, $shieldenh;
    global $armor_materials;

armor_do_over:
    if (rand(0, 3) === 0)
    {
        $arm = arr($shields);
        $is_shield = TRUE;
    }
    else
    {
        $arm = arr($armors);
        $is_shield = FALSE;
    }
            
    $r = rand(1, 100);
    $mat = new NoMaterial();
    if ($is_shield === FALSE && $arm->material !== None && $r > 69) // TODO: fix materials for shields
    {
        $mat = arr($armor_materials);
        if ($mat->armor_cost($arm) === MAT_INVALID)
            $mat = new NoMaterial();
    }

    $final = new ItemEntry();
    $mat_name = $mat->name();
    $final->name = $is_shield ? shield_name() : armor_name($arm->type);
    $final->desc = ($mat_name !== '' ? $mat_name . ' ' : '') . $arm->name;
    $final->cost = $arm->cost + $mat->armor_cost($arm);
    $final->icon = $is_shield ? 'shield' : 'armor';
    
    $count = 0;
    $added_cost = 0;
    while ($count < 5 && (cost_armor($final, $added_cost) < $floor || cost_armor($final, $added_cost) < ($ceiling - $floor) / 2)) {
        $enh = $is_shield ? arr($shieldenh) : arr($armorenh);
        $count++;
        if (array_search($enh->name, $final->tags) !== FALSE)
            continue;
        if (($enh->enh + $final->enh) > 5)
            continue;
        $sub = $enh->subselect();
        $tag = $enh->name . ($sub !== '' ? ' (' . $sub . ') ' : '');
        $added_cost += $enh->cost;
        $final->enh += $enh->enh;
        array_push($final->tags, $tag);
        if ($final->enh === 0)
            $final->enh = 1;
    }

    // special case for bracers of armor
    if ($arm->name === 'bracers of armor')
    {
        if ($final->enh === 0)
            goto armor_do_over;
        $final->icon = 'bracers';
    }
    if (cost_armor($final, $added_cost) > $ceiling * 1.10)
        goto armor_do_over;

    if ($final->enh > 0)
        array_unshift($final->tags, '+' . $final->enh . ' AC (enhancement)');
    $final->desc .= ' (AC' . NBSP . ($arm->ac + $final->enh) . ')';
    $final->cost = cost_armor($final, $added_cost, 0.10); // 10% cost campaign

    return $final;
}

?>