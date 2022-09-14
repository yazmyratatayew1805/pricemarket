<?php

namespace App\Domain\Order\Reactors;

use App\Domain\Order\Actions\CompleteOrder;
use App\Domain\Order\Projections\Order;
use App\Domain\Payment\Events\PaymentPaid;
use App\Domain\Payment\Projections\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class OrderPaymentPaidReactor extends Reactor implements ShouldQueue
{
    public function onPaymentPaid(PaymentPaid $event): void
    {
        /** @var Payment $payment */
        $payment = Payment::findOrFail($event->paymentUuid);

        $invoicePath = $this->createInvoice($payment->order);

        (new CompleteOrder)($payment->order, $invoicePath);
    }

    protected function createInvoice(Order $order): string
    {
        $html = view('orders.invoice', [
            'order' => $order,
        ])->render();

        $timestamp = now()->format('Y-m-d');

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('invoice');

        $invoicePath = $disk->path("{$timestamp}_{$order->order_number}.pdf");

        Browsershot::html($html)->savePdf($invoicePath);

        return $invoicePath;
    }
}
