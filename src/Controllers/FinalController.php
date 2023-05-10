<?php

namespace DarkMegas\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use DarkMegas\LaravelInstaller\Events\LaravelInstallerFinished;
use DarkMegas\LaravelInstaller\Helpers\EnvironmentManager;
use DarkMegas\LaravelInstaller\Helpers\FinalInstallManager;
use DarkMegas\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \DarkMegas\LaravelInstaller\Helpers\InstalledFileManager $fileManager
     * @param \DarkMegas\LaravelInstaller\Helpers\FinalInstallManager $finalInstall
     * @param \DarkMegas\LaravelInstaller\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
