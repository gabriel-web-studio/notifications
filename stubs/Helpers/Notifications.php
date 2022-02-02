<?php

namespace App\Helpers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class Notifications
{
    public array $icons = [
        'success' => 'fa-check-circle text-green-500',
        'info' => 'fa-info-circle text-blue-500',
        'warning' => 'fa-question-circle text-yellow-500',
        'error' => 'fa-exclamation-circle text-red-500',
    ];

    /**
     * @param array $notification
     * @return Factory|View|Application
     */
    public function generate(array $notification): Factory|View|Application
    {
        return $this->float($notification);
    }

    /**
     * @param array $notification
     * @return Factory|View|Application
     */
    protected function float(array $notification): Factory|View|Application
    {
        return view('components.toast-notification', compact('notification'));
    }
}
