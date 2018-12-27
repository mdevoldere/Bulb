<?php

namespace Bulb\Models;


class Event extends Product
{

    public $date_start = '2019-01-01 01:00:00';

    public $date_end = '2019-01-01 02:00:00';

    public $num_places = 0;

    public $location = 'France';

    public function __construct($_id = 'Event', ?string $_name = 'Event Name')
    {
        parent::__construct($_id);
    }

    public function ToArray(): array
    {
        $r = parent::ToArray();

        $r['length'] = '00h00';

        if(!empty($this->date_start))
        {
            if(empty($this->date_end))
                $this->date_end = $this->date_start;

            $s = new \DateTime($this->date_start);
            $e = new \DateTime($this->date_end);

            $diff = $s->diff($e);

            $r['length'] = $diff->format("%H:%I");
        }

        return $r;
    }

}