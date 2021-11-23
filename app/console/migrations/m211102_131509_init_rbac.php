<?php

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

        // ------------------------------ USER ---------------------------------------------

        $ruleUser = new UserRule;
        $rulePerfil = new PerfilRule;
        $auth->add($ruleUser);
        $auth->add($rulePerfil);

        // add "frontendAccess" permission
        $frontendAccess = $auth->createPermission('frontendAccess');
        $frontendAccess->description = 'Frontend Access';
        $auth->add($frontendAccess);

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

        // add "viewUserActivity" permission
        $viewUserActivity = $auth->createPermission('viewUserActivity');
        $viewUserActivity->description = 'View user Activity (User logged)';
        $viewUserActivity->ruleName = $rulePerfil->name;
        $auth->add($viewUserActivity);

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
        $auth->addChild($user, $viewUserActivity);
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
