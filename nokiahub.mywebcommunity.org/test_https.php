<?php
echo file_get_contents("https://example.com") !== false ? "HTTPS OK" : "HTTPS BLOCKED";