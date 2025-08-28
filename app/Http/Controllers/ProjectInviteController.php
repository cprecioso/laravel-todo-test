<?php

namespace App\Http\Controllers;

use App\Mail\InvitedToProject;
use App\Models\Project;
use App\Models\ProjectInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Log;

class ProjectInviteController extends Controller
{
    public function createInviteURL(
        Project $project,
        string $email,
        ?Carbon $expires_at = null
    ) {
        $expires_at ??= now()->addDays();

        $newInvite = ProjectInvite::create([
            'email' => $email,
            'expires_at' => $expires_at,
            'project_id' => $project->id,
        ]);

        return URL::temporarySignedRoute(
            'project-invite.accept',
            $expires_at,
            ['projectInvite' => $newInvite->id],
            absolute: true,
        );
    }

    public function sendInviteEmail(
        Project $project,
        string $email,
        ?Carbon $expires_at = null
    ) {
        $url = $this->createInviteURL($project, $email, $expires_at);
        Mail::to($email)->queue(new InvitedToProject(Auth::user(), $project, $url));
    }

    public function accept(Request $request, ProjectInvite $projectInvite)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Invalid or expired invite link.');
        }

        ProjectInvite::where('email', '=', $projectInvite->email)
            ->each(function ($invite) {
                Auth::user()->guestProjects()->attach($invite->project_id);
                $invite->delete();
            });

        return redirect()->route('project', ['project' => $projectInvite->project()->first()->id]);
    }

    public static function cleanupOldInvites()
    {
        Log::info('Running cleanupOldInvites task');

        $deleteCount = 0;
        ProjectInvite::where('expires_at', '<', now())
            ->each(function ($invite) use (&$deleteCount) {
                $invite->delete();
                $deleteCount++;
            });

        Log::info('Finished cleanupOldInvites task, deleted '.$deleteCount.' invites');
    }
}
