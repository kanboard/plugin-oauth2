<h3><i class="fa fa-lock fa-fw" aria-hidden="true"></i><?= t('OAuth2 Authentication') ?></h3>
<div class="panel">
    <?= $this->form->label(t('Callback URL'), 'oauth2_callback_url') ?>
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('OAuthController', 'handler', array('plugin' => 'OAuth2'), false, '', true) ?>"/>

    <?= $this->form->label(t('Client ID'), 'oauth2_client_id') ?>
    <?= $this->form->password('oauth2_client_id', $values) ?>

    <?= $this->form->label(t('Client Secret'), 'oauth2_client_secret') ?>
    <?= $this->form->password('oauth2_client_secret', $values) ?>

    <?= $this->form->label(t('Authorize URL'), 'oauth2_authorize_url') ?>
    <?= $this->form->text('oauth2_authorize_url', $values) ?>

    <?= $this->form->label(t('Token URL'), 'oauth2_token_url') ?>
    <?= $this->form->text('oauth2_token_url', $values) ?>

    <?= $this->form->label(t('User API URL'), 'oauth2_user_api_url') ?>
    <?= $this->form->text('oauth2_user_api_url', $values) ?>

    <?= $this->form->label(t('Scopes'), 'oauth2_scopes') ?>
    <?= $this->form->text('oauth2_scopes', $values) ?>

    <?= $this->form->label(t('Username Key'), 'oauth2_key_username') ?>
    <?= $this->form->text('oauth2_key_username', $values) ?>

    <?= $this->form->label(t('Name Key'), 'oauth2_key_name') ?>
    <?= $this->form->text('oauth2_key_name', $values) ?>

    <?= $this->form->label(t('Email Key'), 'oauth2_key_email') ?>
    <?= $this->form->text('oauth2_key_email', $values) ?>

    <?= $this->form->label(t('User ID Key'), 'oauth2_key_user_id') ?>
    <?= $this->form->text('oauth2_key_user_id', $values) ?>

    <?= $this->form->hidden('oauth2_account_creation', array('oauth2_account_creation' => 0)) ?>
    <?= $this->form->checkbox('oauth2_account_creation', t('Allow Account Creation'), 1, isset($values['oauth2_account_creation']) && $values['oauth2_account_creation'] == 1) ?>

    <?= $this->form->label(t('Allow account creation only for those domains'), 'oauth2_email_domains') ?>
    <?= $this->form->text('oauth2_email_domains', $values) ?>
    <p class="form-help"><?= t('Use a comma to enter multiple domains: domain1.tld, domain2.tld') ?></p>

    <?= $this->form->label(t('Groups Key'), 'oauth2_key_groups') ?>
    <?= $this->form->text('oauth2_key_groups', $values) ?>
    <p class="form-help"><?= t('Leave empty, when no group mapping is wanted') ?></p>

    <?= $this->form->label(t('Group Filter'), 'oauth2_key_group_filter') ?>
    <?= $this->form->text('oauth2_key_group_filter', $values) ?>
    <p class="form-help"><?= t('Use a comma to enter multiple useable groups: group1,group2') ?></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
