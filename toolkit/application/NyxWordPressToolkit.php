<?php

    namespace nyx;

    use function in_array;

    /**
     * NYX WordPress Toolkit
     *
     * @package nyx
     */
    final class NyxWordPressToolkit
    {
        public const DEFAULT_BEHAVIOR_ENABLED  = 'enabled';
        public const DEFAULT_BEHAVIOR_DISABLED = 'disabled';

        /**
         * @var NyxWordPressToolkit|null
         */
        private static ?NyxWordPressToolkit $_instance = null;

        /**
         * @var array
         */
        private array $config = [];

        /**
         * @var bool
         */
        private bool $initialized = false;

        /**
         * @var string
         */
        private string $verificationBehavior = self::DEFAULT_BEHAVIOR_ENABLED;

        #region Internal
        /**
         * NyxWordPressToolkit constructor.
         */
        private function __construct()
        {
        }

        /**
         * NyxWordPressToolkit clone.
         */
        private function __clone()
        {
        }

        /**
         * NyxWordPressToolkit wakeup.
         *
         * @noinspection PhpUnusedPrivateMethodInspection
         */
        private function __wakeup()
        {
        }
        #endregion

        #region Instance
        /**
         * @return NyxWordPressToolkit
         */
        public static function instance(): NyxWordPressToolkit
        {
            if (self::$_instance === null) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }
        #endregion

        #region Initialization
        /**
         * @param array $config
         *
         * @return NyxWordPressToolkit
         */
        public static function init(array $config = []): NyxWordPressToolkit
        {
            $nyx = self::instance();

            $nyx->config = ['basePath' => $config['basePath']];

            $nyx->initialized = true;

            $nyx->applyDefaultBehavior();

            $functionalities = [
                'acf'            => ['settings'],
                'cache'          => ['main'],
                'cron'           => ['main'],
                'dashboard'      => ['admin'],
                'google-maps'    => ['main'],
                'helpers'        => ['main', 'url', 'login', 'content', 'template', 'formatters', 'images', 'google-maps', 'taxonomies', 'videos', 'date-time', 'php8'],
                'login'          => ['main'],
                'login-required' => ['main'],
                'mail'           => ['main'],
                'rest'           => ['main'],
                'rewrite'        => ['main'],
                'security'       => ['generic', 'head'],
                'server-reports' => ['main'],
                'uploads'        => ['files'],
                'users'          => ['avatars'],
            ];

            foreach ($functionalities as $component => $subComponents) {
                foreach ($subComponents as $subComponent) {
                    if (!$nyx->isComponentEnabled($component, $subComponent)) {
                        continue;
                    }

                    $nyx->load($component, $subComponent);
                }
            }

            return $nyx;
        }
        #endregion

        #region Getters
        /**
         * @return array
         */
        public function getConfig(): array
        {
            return $this->config;
        }
        #endregion

        #region Functionality
        /**
         * @return void
         */
        private function applyDefaultBehavior(): void
        {
            $behavior = apply_filters('nyx_wptk_default_behavior', null);

            if (in_array($behavior, [self::DEFAULT_BEHAVIOR_ENABLED, self::DEFAULT_BEHAVIOR_DISABLED], true)) {
                $this->verificationBehavior = $behavior;
            }
        }
        #endregion

        #region Loaders
        /**
         * @param string $component
         * @param string $item
         *
         * @return void
         *
         * @noinspection UntrustedInclusionInspection
         * @noinspection PhpIncludeInspection
         */
        private function load(string $component, string $item): void
        {
            $basePath = $this->config['basePath'];

            if (!empty($component)) {
                $component = "{$component}/";
            }

            $file = "{$basePath}/toolkit/{$component}{$item}.php";

            if (is_file($file)) {
                require_once($file);
            }
        }
        #endregion

        #region Verifications
        /**
         * @param string $component
         * @param string $subComponent
         *
         * @return bool
         */
        private function isComponentEnabled(string $component, string $subComponent): bool
        {
            if (!$this->initialized) {
                return false;
            }

            $filterName = "nyx_wptk_{$component}_{$subComponent}_enabled";

            $enabled = apply_filters($filterName, null);

            if (!in_array($enabled, [true, false], true)) {
                return $this->isEnabledByDefault();
            }

            return $enabled;
        }

        /**
         * @return bool
         */
        private function isEnabledByDefault(): bool
        {
            return ($this->verificationBehavior === self::DEFAULT_BEHAVIOR_ENABLED);
        }
        #endregion
    }