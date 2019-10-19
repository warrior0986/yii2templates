<?php

namespace app\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use app\models\Role;
use app\models\Menu;
use app\models\User;
use yii\web\ForbiddenHttpException;

class RolesController extends \yii\web\Controller
{
    protected $_auth;

    public function init() {
        $this->_auth = Yii::$app->authManager;
    }

    public function actionAssignPermissions($role)
    {
        if (Yii::$app->user->can('roles-assignpermissions') || Yii::$app->params["enableRBAC"] == false) {
            if (Yii::$app->request->isGet) {
                $roleObject = $this->_auth->getRole($role);
                $controllersAndActions = $this->_getControllersAndActions();
                $dropDownOptions = [];
                $assignedPermissions = $this->_auth->getPermissionsByRole($role);
                $dropDownOptionsAssigned = [];
    
                foreach ($controllersAndActions as $key => $option) {
                    $singleController = str_replace('Controller', '', $key);
                    $singleOption = [];
                    $arrayActions = [];
                    foreach ($option as $action) {
                        $dropDownOptions[$singleController][strtolower($singleController) . '-' . $action] = ucfirst($singleController) . '-' . ucfirst($action);
                        if (array_key_exists(strtolower($singleController) . '-' . $action, $assignedPermissions)) {
                            array_push($dropDownOptionsAssigned, strtolower($singleController) . '-' . $action);
                        }
                    }
                }
    
                $menuOptions = Menu::getMenuOptions();
                $dropDownOptions['Menu Options'] = $menuOptions;
    
                foreach ($menuOptions as $key => $option) {
                    if (array_key_exists(strtolower($option), $assignedPermissions)) {
                        array_push($dropDownOptionsAssigned, strtolower($option));
                    }
                }
    
                return $this->render('assign-permissions', [
                    'role' => $role,
                    'dropDownData' => $dropDownOptions,
                    'dropDownDataAssigned' => $dropDownOptionsAssigned,
                ]);
            } else if (Yii::$app->request->isPost) {
                $permissions= Yii::$app->request->post('permissions');
                $roleObject = $this->_auth->getRole($role);
                $this->_auth->removeChildren($roleObject);
                try {
                    if (!is_null($permissions)) {
                        foreach ($permissions as $permission) {
                            $permissionObject = $this->_auth->getPermission($permission);
                            if(is_null($permissionObject))
                            {
                                $permissionObject=$this->_auth->createPermission($permission);
                                $this->_auth->add($permissionObject);
                            }
                            $permissionObject->description=$permission;
                            $this->_auth->addChild($roleObject, $permissionObject);
                        }
                        Yii::$app->getSession()->setFlash('success', [
                            'message' => 'Permissions assigned successfully',
                            'title' => 'Success',
                            'type' => 'success'
                        ]);
                    }
                    return $this->redirect(['/roles/index']);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => 'Permissions can\'t be assigned, Error: ' . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                    return $this->render('assign-permissions', [
                        'role' => $role,
                        'dropDownData' => $dropDownOptions,
                    ]);
                }
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionAssignUsers($role)
    {
        if (Yii::$app->user->can('roles-assignusers') || Yii::$app->params["enableRBAC"] == false) {
            $users = User::find()->all();
            $usersByRole = $this->_auth->getUserIdsByRole($role);
            if (Yii::$app->request->isGet) {
                $role = $this->_auth->getRole($role);
                
                return $this->render('assign-users', [
                    'role' => $role,
                    'usersByRole' => $usersByRole,
                    'users' => ArrayHelper::map($users, 'id', 'email'),
                ]);
            } else if (Yii::$app->request->isPost) {
                $usersToSet = Yii::$app->request->post('users');
                $roleObject = $this->_auth->getRole($role);
                foreach ($users as $key => $user) {
                    $this->_auth->revoke($roleObject, $user->id);
                }
                try {
                    if (!is_null($usersToSet)) {
                        foreach ($usersToSet as $key => $user) {
                            $this->_auth->assign($roleObject, $user);
                        }
                        Yii::$app->getSession()->setFlash('success', [
                            'message' => 'Permissions assigned successfully',
                            'title' => 'Success',
                            'type' => 'success'
                        ]);
                    }
                    return $this->redirect(['/roles/index']);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => "Users can't be assigned, Error: " . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                    return $this->render('assign-users', [
                        'role' => $roleObject,
                        'users' => ArrayHelper::map($users, 'id', 'email'),
                        'usersByRole' => $usersByRole,
                    ]);
                }
            }
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->user->can('roles-create') || Yii::$app->params["enableRBAC"] == false) {
            $model = new Role();
    
            if ($model->load(Yii::$app->request->post())) {
                try {
                    $role = $this->_auth->createRole($model->name);
                    $role->description = $model->description;
                    $this->_auth->add($role);
                    Yii::$app->getSession()->setFlash('success', [
                        'message' => 'Role created successfully',
                        'title' => 'Success',
                        'type' => 'success'
                    ]);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => 'Role can not be created, Error: ' . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                }
                return $this->redirect(['/roles/index']);
            }
    
            return $this->render('create', [
                'model' => $model,
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionDelete($id)
    {
        if (Yii::$app->user->can('roles-delete') || Yii::$app->params["enableRBAC"] == false) {
            $role = $this->_auth->getRole($id);
            $this->_auth->remove($role);
            Yii::$app->getSession()->setFlash('success', [
                'message' => 'Role deleted successfully',
                'title' => 'Success',
                'type' => 'success'
            ]);
    
            return $this->redirect(['/roles/index']);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->can('roles-update') || Yii::$app->params["enableRBAC"] == false) {
            $model = new Role();
    
            if (Yii::$app->request->isGet) {
                $role = $this->_auth->getRole($id);
                $model->type = $role->type;
                $model->name = $role->name;
                $model->description = $role->description;
                $model->oldName = $role->name;
            }
    
            if (Yii::$app->request->isPost) {
                $model->load(Yii::$app->request->post());
                $oldName = Yii::$app->request->post('oldName');
                try {
                    $role= $this->_auth->getRole($model->oldName);
                    $role->name= $model->name;
                    $role->description= $model->description;
                    $this->_auth->update($model->oldName, $role);
                    Yii::$app->getSession()->setFlash('success', [
                        'message' => 'Role updated successfully',
                        'title' => 'Success',
                        'type' => 'success'
                    ]);
                } catch (\yii\db\Exception $e) {
                    Yii::$app->getSession()->setFlash('error', [
                        'message' => 'Role can not be updated, Error: ' . $e->getName(),
                        'title' => 'Error',
                        'type' => 'error'
                    ]);
                }
                return $this->redirect(['/roles/index']);
            }
    
            return $this->render('update', [
                'model' => $model
            ]);
        } else {
            throw new ForbiddenHttpException;
        }      
    }

    public function actionIndex()
    {
        if (Yii::$app->user->can('roles-index') || Yii::$app->params["enableRBAC"] == false) {
            $roles = $this->_auth->getRoles();
    
            $dataProvider = new ArrayDataProvider([
                'allModels' => $roles,
            ]);
            return $this->render('index', [
                'rolesDataProvider' => $dataProvider
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    public function actionView($id)
    {
        if (Yii::$app->user->can('roles-view') || Yii::$app->params["enableRBAC"] == false) {
            return $this->render('view', [
                'role' => $this->_auth->getRole($id),
            ]);
        } else {
            throw new ForbiddenHttpException;
        }
    }

    protected function _getControllersAndActions()
    {
        $controllerlist = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerlist[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerlist);
        $fulllist = [];
        foreach ($controllerlist as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        return $fulllist;
    }
}
