<?php

namespace Corals\Modules\Shortener\Services;


use Corals\Foundation\Services\BaseServiceClass;
use Corals\Modules\Shortener\Models\Link;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ImpressionService extends BaseServiceClass
{
    /**
     * @param Request $request
     * @param $codeLink
     * @return \Illuminate\Http\RedirectResponse
     */
    public function click(Request $request, $codeLink)
    {
        $link = Link::findByCode($codeLink);

        $link->impressions()->create($this->getAgentDetails($request));

        if ($link->show_splash_page) {
            return redirect(url('s/' . $codeLink));
        }

        return redirect()->to($link->full_url);
    }

    /**
     * @param $request
     * @return array
     */
    protected function getAgentDetails($request): array
    {
        $details = [
            'ip_address' => $request->getClientIp(),
            'referer' => $request->headers->get('referer'),
        ];

        return rescue(function () use ($details) {
            $agent = new Agent();

            $details['browser'] = $agent->browser();
            $details['browser_version'] = $agent->version($details['browser']);
            $details['is_phone'] = $agent->isPhone();
            $details['is_tablet'] = $agent->isTablet();
            $details['is_desktop'] = $agent->isDesktop();
            $details['is_robot'] = $agent->isRobot();
            $details['robot'] = $agent->robot();
            $details['device'] = $agent->device();
            $details['platform'] = $agent->platform();
            $details['platform_version'] = $agent->version($details['platform']);
            $details['languages'] = $agent->languages();

            return $details;
        }, function () use ($details) {
            return $details;
        });
    }
}
