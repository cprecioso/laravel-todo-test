<?php

namespace App\Http\Controllers;

use App\Mail\InvitedToProject;
use App\Models\Project;
use App\Models\ProjectInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Log;

class ProjectInviteController extends Controller
{
    public function createInviteURL(
        Project $project,
        string $email,
        Carbon|null $expires_at = null
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
        Carbon|null $expires_at = null
    ) {
        $url = $this->createInviteURL($project, $email, $expires_at);
        Mail::to($email)->queue(new InvitedToProject(Auth::user(), $project, $url));
    }

    public function accept(Request $request, ProjectInvite $projectInvite)
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'Invalid or expired invite link.');
        }

        DB::transaction(function () use ($projectInvite) {
            $allInvites = ProjectInvite::where('email', $projectInvite->email)->get();

            foreach ($allInvites as $invite) {
                DB::transaction(function () use ($invite) {
                    Auth::user()->guestProjects()->attach($invite->project_id);
                    $invite->delete();
                });
            }
        });

        Log::info($projectInvite);

        return redirect()->route('project', ['project' => $projectInvite->project()->first()->id]);
    }
}
