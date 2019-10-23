<?php

set_include_path(get_include_path().PATH_SEPARATOR.'app/');
spl_autoload_extensions('.php, .inc');
spl_autoload_register();


