<div class="container">
    <h1>User profile</h1>

    <div class="box">

        <!-- echo out the system feedback (error and success messages) -->
        <?php $this->renderFeedbackMessages(); ?>

        <div>Username: <?= $this->user_name; ?></div>
        <div>Email: <?= $this->user_email; ?></div>
        <div>Avatar:
            <?php if (Config::get('USE_GRAVATAR')) { ?>
                Your gravatar pic (on gravatar.com): <img src='<?= $this->user_gravatar_image_url; ?>' />
            <?php } else { ?>
                Picture: <img src='<?= $this->user_avatar_file; ?>' />
            <?php } ?>
        </div>
        <div>Your account type is: <?= AllModel::getAccountType($this->user_account_type); ?></div>
    </div>
</div>
