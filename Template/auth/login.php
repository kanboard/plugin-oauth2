<ul class="no-bullet">
    <li>
        <i class="fa fa-lock fa-fw" aria-hidden="true"></i>
        <?= $this->url->link(t('OAuth2 login'), 'OAuthController', 'handler', array('plugin' => 'OAuth2')) ?>
    </li>
</ul>
