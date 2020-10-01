<ul class="no-bullet">
    <li>
        <?php if (!empty($oauth2_custom_login_text)): ?>
            <?= $this->url->icon('lock', t($oauth2_custom_login_text), 'OAuthController', 'handler', array('plugin' => 'OAuth2')) ?>
        <?php else: ?>
            <?= $this->url->icon('lock', t('OAuth2 login'), 'OAuthController', 'handler', array('plugin' => 'OAuth2')) ?>
        <?php endif; ?>
    </li>
</ul>
