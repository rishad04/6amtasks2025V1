<?php

namespace Lorisleiva\CronTranslator;

/**
 * Hours field translation class
 */
class HoursField extends Field
{

    /**
     * Field position
     * 
     * @var int
     */
    public int $position = 1;

    /**
     * Translate every expression
     *
     * @return string
     */
    public function translateEvery(): string
    {
        if ($this->expression->minute->hasType('Once')) {
            return $this->lang('hours.once_an_hour');
        }

        return $this->lang('hours.every');
    }

    /**
     * Translate increment expression
     *
     * @return string
     */
    public function translateIncrement(): string
    {
        if ($this->expression->minute->hasType('Once')) {
            return $this->lang('hours.times_per_increment', [
                'times' => $this->getTimes(),
                'increment' => $this->getIncrement()
            ]);
        }

        if ($this->getCount() > 1) {
            return $this->lang('hours.multiple_per_increment', [
                'count' => $this->getCount(),
                'increment' => $this->getIncrement()
            ]);
        }

        if ($this->expression->minute->hasType('Every')) {
            return $this->lang('hours.increment_chained', [
                'increment' => $this->getIncrement()
            ]);
        }

        return $this->lang('hours.increment', [
            'increment' => $this->getIncrement()
        ]);
    }

    /**
     * Translate multiple expression
     *
     * @return string
     */
    public function translateMultiple(): string
    {
        if ($this->expression->minute->hasType('Once')) {
            return $this->lang('hours.times_per_day', [
                'times' => $this->getTimes()
            ]);
        }

        return $this->lang('hours.multiple_per_day', [
            'count' => $this->getCount()
        ]);
    }

    /**
     * Translate once expression
     *
     * @return string
     */
    public function translateOnce(): string
    {
        $minute = $this->expression->minute->hasType('Once') ? $this->expression->minute : null;

        return $this->lang('hours.once_at_time', [
            'time' => $this->format($minute)
        ]);
    }

    /**
     * Format the hour
     *
     * @param MinutesField|null $minute
     * @return string
     */
    public function format(?MinutesField $minute = null): string
    {
        if ($this->expression->timeFormat24hours) {
            $hour = $this->getValue();
            return $minute ? "$hour:{$minute->format()}" : "$hour:00";
        }

        $amOrPm = $this->getValue() < 12 ? $this->lang('times.am') : $this->lang('times.pm');
        $hour = $this->getValue() % 12;
        $hour = $hour === 0 ? 12 : $hour;

        return $minute ? "$hour:{$minute->format()}$amOrPm" : "$hour$amOrPm";
    }
}
