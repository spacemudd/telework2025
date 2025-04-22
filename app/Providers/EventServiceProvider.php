<?php

namespace App\Providers;

use App\Events\CompanyApprovedEvent;
use App\Events\EmployeeAddedEvent;
use App\Listeners\CreateCompanyAccount;
use App\Listeners\CreateEmployeeAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSent;
use App\Listeners\LogSentEmails;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyApprovedEvent::class => [
            CreateCompanyAccount::class,
        ],
        EmployeeAddedEvent::class => [
            CreateEmployeeAccount::class,
        ],
        MessageSent::class => [
            LogSentEmails::class,
        ],
    ];
}
