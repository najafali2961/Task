<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlesFilesTrait
{
    /**
     * Process file attachments for a ticket.
     *
     * @param  \App\Models\Tickets  $ticket
     * @param  array  $files
     * @return void
     */
    protected function handleFiles($ticket, $files)
    {
        foreach ($files as $file) {

            $fileHash = md5_file($file->getRealPath());
            $exists = $ticket->files()->where('file_path', 'like', '%' . $fileHash . '%')->exists();

            if (!$exists) {
                $path = $file->store('tickets', 'public');
                $ticket->files()->create([
                    'file_path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }
    }

    /**
     * Remove files by their IDs.
     *
     * @param  \App\Models\Tickets  $ticket
     * @param  array  $fileIds
     * @return void
     */
    protected function removeFiles($ticket, array $fileIds)
    {
        $ticket->files()->whereIn('id', $fileIds)->get()->each(function ($file) {
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        });
    }
}
