<?php
function roll_potion($floor, $ceiling)
{
    global $potions;
    
    $r = rand(1, 100);
    if ($ceiling > 50000) // major
    {
        if (inr($r, 1, 20))
            $pot = arr($potions[2]);
        else
            $pot = arr($potions[3]);
    }
    else if ($ceiling > 10000) // medium
    {
        if (inr($r, 1, 20))
            $pot = arr($potions[1]);
        else if (inr($r, 21, 60))
            $pot = arr($potions[2]);
        else
            $pot = arr($potions[3]);
    }
    else // minor
    {
        if (inr($r, 1, 20))
            $pot = arr($potions[0]);
        else if (inr($r, 21, 60))
            $pot = arr($potions[1]);
        else
            $pot = arr($potions[2]);
    }
    
    $final = new ItemEntry();
    $final->name = 'potion of ' . $pot->name;
    $final->icon = 'potion' . ($pot->level > 1 ? '2' : '1');
    $sub = $pot->subselect();
    if ($sub !== '')
        $final->name .= ' (' . $sub . ')';
    $final->desc = to_ordinal($pot->level) . '-level potion';
    $final->cost = $pot->cost;
    
    return $final;
}

function roll_ring($floor, $ceiling)
{
    global $rings;
    $rings_trimmed = filter_by_cost($rings, $floor, $ceiling);
    if (count($rings_trimmed) === 0)
        return glitch();
        
    $count = 0;
ring_do_over:
    $item = arr($rings_trimmed);
    
    $final = new ItemEntry();
    $final->name = $item->name;
    $final->icon = 'ring';
    $sub = $item->subselect();
    if ($sub !== '')
        $final->name .= ' (' . $sub . ')';
    $final->desc = 'ring';
    
    if (inr($item->cost, 2000, 7999))
    {
        $final->cost = $item->cost + 2000;
        array_push($final->tags, '+1 AC (deflection)');
    }
    else if (inr($item->cost, 8000, 17999))
    {
        $final->cost = $item->cost + 8000;
        array_push($final->tags, '+2 AC (deflection)');
    }
    else if (inr($item->cost, 18000, 31999))
    {
        $final->cost = $item->cost + 18000;
        array_push($final->tags, '+3 AC (deflection)');
    }
    else if (inr($item->cost, 32000, 49999))
    {
        $final->cost = $item->cost + 32000;
        array_push($final->tags, '+4 AC (deflection)');
    }
    else if ($item->cost > 49999)
    {
        $final->cost = $item->cost + 50000;
        array_push($final->tags, '+5 AC (deflection)');
    }
    else
    {
        $final->cost = $item->cost;
    }
    
    if ($count++ > 9)
        return glitch();
    if ($final->cost < $floor || $final->cost > ($ceiling * 1.10))
        goto ring_do_over;

    $final->cost = round($final->cost * 0.5); // 50% cost campaign
    return $final;
}

function roll_rod($floor, $ceiling)
{
    global $rods;
    $rods_trimmed = filter_by_cost($rods, min($floor, 40000), $ceiling);
    if (count($rods_trimmed) === 0)
        return glitch();

    $rod = arr($rods_trimmed);
    
    $final = new ItemEntry();
    $final->name = $rod->name;
    $sub = $rod->subselect();
    if ($sub !== '')
        $final->name .= ' (' . $sub . ')';
    $final->desc = 'magic rod';
    $final->cost = $rod->cost;
    $final->icon = 'rod';
    
    return $final;
}

function roll_scroll($floor, $ceiling)
{
    global $arcane, $divine;
    
    $scroll_type = inr(rand(1, 10), 1, 7) ? 'arcane' : 'divine';
    if ($scroll_type === 'arcane')
        $scrolls = &$arcane;
    else
        $scrolls = &$divine;

    $scr = [];
    $r = rand(1, 100);
    if (inr($r, 1, 80))
        $c = 1;
    else if (inr($r, 81, 95))
        $c = 2;
    else
        $c = 3;
    for ($i = 0; $i < $c; $i++)
    {
        $r = rand(1, 100);
        if ($ceiling > 100000) // major
        {
            if (inr($r, 1, 5))
                $item = arr($scrolls[4]);
            else if (inr($r, 6, 50))
                $item = arr($scrolls[5]);
            else if (inr($r, 51, 70))
                $item = arr($scrolls[6]);
            else if (inr($r, 71, 85))
                $item = arr($scrolls[7]);
            else if (inr($r, 86, 95))
                $item = arr($scrolls[8]);
            else
                $item = arr($scrolls[9]);
        }
        else if ($ceiling > 20000) // medium
        {
            if (inr($r, 1, 5))
                $item = arr($scrolls[2]);
            else if (inr($r, 6, 65))
                $item = arr($scrolls[3]);
            else if (inr($r, 66, 95))
                $item = arr($scrolls[4]);
            else
                $item = arr($scrolls[5]);
        }
        else // minor
        {
            if (inr($r, 1, 5))
                $item = arr($scrolls[0]);
            else if (inr($r, 6, 50))
                $item = arr($scrolls[1]);
            else if (inr($r, 51, 95))
                $item = arr($scrolls[2]);
            else
                $item = arr($scrolls[3]);
        }
        array_push($scr, $item);
    }

    $final = new ItemEntry();
    $final->icon = 'scroll-' . $scroll_type;
    if (count($scr) > 1)
    {
        $final->name = 'scroll of  ' . $scroll_type . ' spells';
        $final->desc = $scroll_type . ' scroll';
        foreach ($scr as $s)
        {
            $tag = $s->name . ' (' . to_ordinal($s->level) . ' level)';
            $final->cost += $s->cost;
            array_push($final->tags, $tag);
        }
    }
    else
    {
        $final->name = 'scroll of ' . $scr[0]->name;
        $final->desc = to_ordinal($scr[0]->level) . '-level ' . $scroll_type . ' scroll';
        $final->cost = $scr[0]->cost;
    }
    
    return $final;
}

function roll_staff($floor, $ceiling)
{
    global $staves;
    $st = filter_by_cost($staves, $floor, $ceiling);
    if (count($st) === 0)
        return glitch();
    
    $item = arr($st);
    $final = new ItemEntry();
    $final->name = $item->name;
    $final->desc = 'magic staff';
    $final->cost = $item->cost;
    $final->icon = 'staff';
    return $final;
}

function roll_wand($floor, $ceiling)
{
    global $wands;
    
    $r = rand(1, 100);
    if ($ceiling > 50000) // major
    {
        if (inr($r, 1, 60))
            $wand = arr($wands[3]);
        else
            $wand = arr($wands[4]);
    }
    else if ($ceiling > 20000) // medium
    {
        if (inr($r, 1, 60))
            $wand = arr($wands[2]);
        else
            $wand = arr($wands[3]);
    }
    else // minor
    {
        if (inr($r, 1, 5))
            $wand = arr($wands[0]);
        else if (inr($r, 6, 60))
            $wand = arr($wands[1]);
        else
            $wand = arr($wands[2]);
    }
    
    $final = new ItemEntry();
    $final->name = 'wand of ' . $wand->name;
    $final->desc = to_ordinal($wand->level) . '-level wand';
    $final->icon = 'wand';
    $final->cost = $wand->cost;
    
    return $final;
}
?>