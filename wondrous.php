<?php
function body_enhancement($cost, $entry)
{
    global $abilities_p;
    ability_enhancement($cost, $entry, $abilities_p);
}

function head_enhancement($cost, $entry)
{
    global $abilities_m;
    ability_enhancement($cost, $entry, $abilities_m);
}

function ability_enhancement($cost, $entry, $abil)
{
    $ab = $abil;
    shuffle($ab);
    $entry->cost = $cost;
    if (inr($cost, 4000, 9999))
    {
        array_push($entry->tags, '+2 ' . array_pop($ab));
        $entry->cost += 4000;
    }
    else if (inr($cost, 10000, 15999))
    {
        array_push($entry->tags, '+2 ' . array_pop($ab));
        array_push($entry->tags, '+2 ' . array_pop($ab));
        $entry->cost += 10000;
    }
    else if (inr($cost, 16000, 35999))
    {
        if (rand(0, 1) === 0)
        {
            array_push($entry->tags, '+4 ' . array_pop($ab));
        }
        else
        {
            array_push($entry->tags, '+2 ' . array_pop($ab));
            array_push($entry->tags, '+2 ' . array_pop($ab));
            array_push($entry->tags, '+2 ' . array_pop($ab));
        }
        $entry->cost += 16000;        
    }
    else if (inr($cost, 36000, 39999))
    {
        if (rand(0, 1) === 0)
        {
            array_push($entry->tags, '+6 ' . array_pop($ab));
        }
        else
        {
            array_push($entry->tags, '+4 ' . array_pop($ab));
            array_push($entry->tags, '+2 ' . array_pop($ab));
            array_push($entry->tags, '+2 ' . array_pop($ab));
        }
        $entry->cost += 36000;
    }
    else if (inr($cost, 40000, 63999))
    {
        // TODO: select earlier choice?
        array_push($entry->tags, '+4 ' . array_pop($ab));
        array_push($entry->tags, '+4 ' . array_pop($ab));
        $entry->cost += 40000;
    }
    else if (inr($cost, 64000, 89999))
    {
        if (rand(0, 1) === 0)
        {
            array_push($entry->tags, '+6 ' . array_pop($ab));
            array_push($entry->tags, '+4 ' . array_pop($ab));
        }
        else
        {
            array_push($entry->tags, '+4 ' . array_pop($ab));
            array_push($entry->tags, '+4 ' . array_pop($ab));
            array_push($entry->tags, '+4 ' . array_pop($ab));           
        }
        $entry->cost += 64000;
    }
    else if (inr($cost, 90000, 143999))
    {
        if (rand(0, 1) === 0)
        {
            array_push($entry->tags, '+6 ' . array_pop($ab));
            array_push($entry->tags, '+6 ' . array_pop($ab));
        }
        else
        {
            array_push($entry->tags, '+6 ' . array_pop($ab));
            array_push($entry->tags, '+4 ' . array_pop($ab));
            array_push($entry->tags, '+4 ' . array_pop($ab));           
        }
        $entry->cost += 90000;        
    }
    else if ($cost > 143999)
    {
        array_push($entry->tags, '+6 ' . array_pop($ab));
        array_push($entry->tags, '+6 ' . array_pop($ab));
        array_push($entry->tags, '+6 ' . array_pop($ab));           
        $entry->cost += 144000;
    }
}

function neck_enhancement($cost, $entry)
{
    $entry->cost = $cost;
    if (inr($cost, 2000, 7999))
    {
        array_push($entry->tags, '+1 AC (natural)');
        $entry->cost += 2000;
    }
    else if (inr($cost, 8000, 17999))
    {
        array_push($entry->tags, '+2 AC (natural)');
        $entry->cost += 8000;
    }
    else if (inr($cost, 18000, 31999))
    {
        array_push($entry->tags, '+3 AC (natural)');
        $entry->cost += 18000;
    }
    else if (inr($cost, 32000, 49999))
    {
        array_push($entry->tags, '+4 AC (natural)');
        $entry->cost += 32000;
    }
    else if ($cost > 49999)
    {
        array_push($entry->tags, '+5 AC (natural)');
        $entry->cost += 50000;
    }
}

function shoulder_enhancement($cost, $entry)
{
    $entry->cost = $cost;
    if (inr($cost, 1000, 3999))
    {
        array_push($entry->tags, '+1 saves (resistance)');
        $entry->cost += 1000;
    }
    else if (inr($cost, 4000, 8999))
    {
        array_push($entry->tags, '+2 saves (resistance)');
        $entry->cost += 4000;
    }
    else if (inr($cost, 9000, 15999))
    {
        array_push($entry->tags, '+3 saves (resistance)');
        $entry->cost += 9000;
    }
    else if (inr($cost, 16000, 24999))
    {
        array_push($entry->tags, '+4 saves (resistance)');
        $entry->cost += 16000;
    }
    else if ($cost > 24999)
    {
        array_push($entry->tags, '+5 saves (resistance)');
        $entry->cost += 25000;
    }
}

function roll_wondrous($floor, $ceiling)
{
    global $w_body, $w_chest, $w_eyes, $w_feet, $w_hands;
    global $w_head, $w_neck, $w_shoulders, $w_slotless, $w_wrists;
    
    $count = 0;
wondrous_do_over:   
    $r = rand(1, 100);
    if (inr($r, 1, 12))
        $w = $w_body; // 1-6 belts, merged into body
    else if (inr($r, 13, 17))
        $w = $w_chest;
    else if (inr($r, 18, 22))
        $w = $w_eyes;
    else if (inr($r, 23, 28))
        $w = $w_feet;
    else if (inr($r, 29, 34))
        $w = $w_hands;
    else if (inr($r, 35, 47))
        $w = $w_head; // 42-47 headband, merged into head
    else if (inr($r, 48, 54))
        $w = $w_neck;
    else if (inr($r, 55, 61))
        $w = $w_shoulders;
    else if (inr($r, 62, 67))
        $w = $w_wrists;
    else if (inr($r, 68, 100))
        $w = $w_slotless;

    $w = filter_by_cost($w, $floor, $ceiling);
    if (count($w) === 0)
        return glitch();
    $item = arr($w);
    
    $final = new ItemEntry();
    $final->name = $item->name;
    $final->desc = $item->desc === '' ? 'slotless' : $item->desc . ' slot';
    $final->icon = 'wondrous';
    if ($item->desc === 'body')
    {
        body_enhancement($item->cost, $final);
    }
    else if ($item->desc === 'head')
    {
        head_enhancement($item->cost, $final);
    }
    else if ($item->desc === 'neck')
    {
        neck_enhancement($item->cost, $final);
    }
    else if ($item->desc === 'shoulders')
    {
        shoulder_enhancement($item->cost, $final);
    }
    else
    {
        $final->cost = $item->cost;
    }
    
    if ($count++ > 9)
        return glitch();
    if ($final->cost < $floor || $final->cost > ($ceiling * 1.10))
        goto wondrous_do_over;

    $final->cost = round($final->cost * 0.5); // 50% cost campaign
    return $final;
}

?>