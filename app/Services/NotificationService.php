<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

class NotificationService
{
    public static function create($userId, $type, $title, $message, $referenceType = null, $referenceId = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    public static function reservationConfirmed($reservation)
    {
        return self::create(
            $reservation->user_id,
            'reservation_confirmed',
            'Réservation confirmée',
            "Votre réservation pour '{$reservation->book->title}' a été confirmée. Code: {$reservation->confirmation_code}",
            'Reservation',
            $reservation->id
        );
    }

    public static function reservationRefused($reservation, $reason)
    {
        return self::create(
            $reservation->user_id,
            'reservation_refused',
            'Réservation refusée',
            "Votre réservation pour '{$reservation->book->title}' a été refusée. Raison: {$reason}",
            'Reservation',
            $reservation->id
        );
    }

    public static function returnReminder($reservation)
    {
        return self::create(
            $reservation->user_id,
            'return_reminder',
            'Rappel de retour',
            "N'oubliez pas de retourner '{$reservation->book->title}' avant le {$reservation->end_date->format('d/m/Y')}",
            'Reservation',
            $reservation->id
        );
    }

    public static function returnOverdue($reservation)
    {
        return self::create(
            $reservation->user_id,
            'return_overdue',
            'Retour en retard',
            "Le livre '{$reservation->book->title}' aurait dû être retourné le {$reservation->end_date->format('d/m/Y')}. Merci de le retourner au plus vite.",
            'Reservation',
            $reservation->id
        );
    }
}
