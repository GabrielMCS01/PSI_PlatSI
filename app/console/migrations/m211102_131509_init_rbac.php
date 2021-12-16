<?php

use console\models\DeleteCommentRule;
use console\models\DeletePostRule;
use console\models\PerfilRule;
use console\models\UserRule;
use yii\db\Migration;



/**
 * Class m211102_131509_init_rbac
 */
class m211102_131509_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // ----------------------------------- USER ---------------------------------------------
        $ruleUser = new UserRule;
        $rulePerfil = new PerfilRule;
        $ruleDeletePost = new DeletePostRule();
        $ruleDeleteComment = new DeleteCommentRule();
        $auth->add($ruleUser);
        $auth->add($rulePerfil);
        $auth->add($ruleDeletePost);
        $auth->add($ruleDeleteComment);

        // add "frontendAccess" permission
        $frontendAccess = $auth->createPermission('frontendAccess');
        $frontendAccess->description = 'Frontend Access';
        $auth->add($frontendAccess);

        // ----------------------- ACTIVITY ------------------------------
        // add "createActivity" permission
        $createActivity = $auth->createPermission('createActivity');
        $createActivity->description = 'Create a Activity';
        $auth->add($createActivity);

        // add "updateActivity" permission
        $updateActivity = $auth->createPermission('updateActivity');
        $updateActivity->description = 'Update Activity (User logged)';
        $updateActivity->ruleName = $ruleUser->name;
        $auth->add($updateActivity);

        // add "deleteActivity" permission
        $deleteActivity = $auth->createPermission('deleteActivity');
        $deleteActivity->description = 'Delete Activity (User logged)';
        $deleteActivity->ruleName = $ruleUser->name;
        $auth->add($deleteActivity);

        // add "viewActivity" permission
        $viewActivity = $auth->createPermission('viewActivity');
        $viewActivity->description = 'View Activity (User logged)';
        $viewActivity->ruleName = $ruleUser->name;
        $auth->add($viewActivity);

        // ----------------------- PROFILE ---------------------------
        // add "updateProfile" permission
        $updateProfile = $auth->createPermission('updateProfile');
        $updateProfile->description = 'Update Profile (User logged)';
        $updateProfile->ruleName = $rulePerfil->name;
        $auth->add($updateProfile);

        // add "deleteProfile" permission
        $deleteProfile = $auth->createPermission('deleteProfile');
        $deleteProfile->description = 'Delete Profile (User logged)';
        $deleteProfile->ruleName = $rulePerfil->name;
        $auth->add($deleteProfile);

        // add "viewProfile" permission
        $viewProfile = $auth->createPermission('viewProfile');
        $viewProfile->description = 'View Profile (User logged)';
        $viewProfile->ruleName = $rulePerfil->name;
        $auth->add($viewProfile);

        // ------------------------ POSTS ---------------------------
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create Post (User logged)';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update Post (User logged)';
        $auth->add($updatePost);

        // add "deletePost" permission
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete Post (User logged) (Moderator can delete Posts made by any User)';
        $deletePost->ruleName = $ruleDeletePost->name;
        $auth->add($deletePost);

        // ------------------------ COMMENTS -------------------------
        // add "updateComment" permission
        $updateComment = $auth->createPermission('updateComment');
        $updateComment->description = 'Update Comment (User logged)';
        $auth->add($updateComment);

        // add "deletePost" permission
        $deleteComment = $auth->createPermission('deleteComment');
        $deleteComment->description = 'Delete Comment (User logged) (Moderator can delete Comments made by any User)';
        $deleteComment->ruleName = $ruleDeleteComment->name;
        $auth->add($deleteComment);

        // add "author" role and give him profile and activity roles
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $frontendAccess);
        $auth->addChild($user, $createActivity);
        $auth->addChild($user, $updateActivity);
        $auth->addChild($user, $deleteActivity);
        $auth->addChild($user, $viewActivity);
        $auth->addChild($user, $updateProfile);
        $auth->addChild($user, $deleteProfile);
        $auth->addChild($user, $viewProfile);
        $auth->addChild($user, $createPost);
        $auth->addChild($user, $updatePost);
        $auth->addChild($user, $deletePost);
        $auth->addChild($user, $updateComment);
        $auth->addChild($user, $deleteComment);

        // ---------------------------- USER --------------------------------------

        // ---------------------------- ADMIN -------------------------------------
        // add "backendAccess" permission
        $backendAccess = $auth->createPermission('backendAccess');
        $backendAccess->description = 'Backend Access';
        $auth->add($backendAccess);

        // add "admin" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $backendAccess);
        // --------------------------- ADMIN ---------------------------------------

        // -------------------------- MODERADOR ------------------------------------
        // add "moderador" role
        $moderador = $auth->createRole('moderador');
        $auth->add($moderador);
        $auth->addChild($moderador, $user);

        // -------------------------- MODERADOR ------------------------------------
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
