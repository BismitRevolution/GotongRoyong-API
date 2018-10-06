<?php

namespace App\Http\Controllers\Fnb;

/**
 * @resource Hotel
 *
 * @author Mahari Hadistian <maharihadistian@gmail.com>
 * @author Robin Dutheil <robin.dutheil@gmail.com>
 * @author Faisal <isalriz9@gmail.com>
 * @copyright 2018 PipeApps
 */

use App\Http\Controllers\Platform\Access,
    App\Http\Controllers\Controller,
    Illuminate\Support\Facades\DB as DB,
    App\Http\Controllers\fnb\Menu\MenuListController as Menu,
    App\Http\Controllers\fnb\Menu\MenuTypeController as MenuType,
    App\Http\Controllers\fnb\Menu\MenuRecipeController as Recipe,
    App\Http\Controllers\fnb\Ingredients\IngredientsListController as Ingredient,
    App\Http\Controllers\Hotel\Reservations\GuestController as Guest,
    App\Http\Controllers\Hotel\Reservations\ReservationManagementController as ChangeRequest,
    App\Http\Controllers\Platform\Property,
    App\Http\Controllers\Platform\Response,
    App\Http\Controllers\Platform\Tools,
    App\Http\Controllers\Platform\User,
    Illuminate\Http\Request;

class MenuController extends Controller
{
  // List //
  public function getListMenu (Request $request){
      //bila parameter tidak dibutuhkan
      $params = Tools::params($request,array(
      ));

      if ($params) {
          $data = (new Menu)->getList($params->h_property_id);
          return Response::send('Menu List', 'content', $data);
      }
      else{
          return Response::send('Wrong Parameters');
      }
  }

  public function getListMenuType (Request $request){
      //bila parameter tidak dibutuhkan
      $params = Tools::params($request,array(
      ));

      if ($params) {
          $data = (new MenuType)->getList($params->h_property_id);
          return Response::send('Menu Type List', 'content', $data);
      }
      else{
          return Response::send('Wrong Parameters');
      }
  }

  public function getMenuDetail (Request $request){
      $valid_params = Tools::params($request,array(
           ['menu_code','string']
      ));
    $item = new Menu($valid_params->menu_code);
    if($item->exist){
       $data = array(
         'menuTypeID'      => $item->menuTypeID,
         'code'      		   => $item->code,
         'name'            => $item->name,
         'price'     		   => $item->price,
         'duration'        => $item->duration,
         'desc'      		   => $item->desc,
         'materialNeeded'  => $item-> getRecipe(),
         'menuTypeInfo'    => $item-> getmenuTypeInfo()
       );
       return Response::send('Menu Detail Content', 'content', $data);
    }
    else{
       return Response::send('Wrong Menu ID');
    }
  }

  public function getReservationDetail (Request $request){
      $params = Tools::params($request,array(
           ['id','string']
	   ));

       if ($valid_params) {
           $data = (new Menu)->getMenuDetail($valid_params->h_property_id, $valid_params->menu_code);

               return Response::send('Menu Detail', 'content', $data);

       }
       else{
           return Response::send('Wrong Parameters');
       }
  }

  public function removeMenu (Request $request){
      $valid_params = Tools::params($request,array(
           ['menu_code','string']
      ));
	   $menu = new Menu($valid_params->menu_code);
       if ($menu->exist) {
		   $menu->remove();
           return Response::send('Menu Removed', 'request');
       }
       else{
           return Response::send('Wrong Menu ID');
       }
  }

  public function createMenu (Request $request){
       $params = Tools::params($request,array(
           ['name','string'],
           ['price','string'],
           ['duration','string'],
           ['menuTypeCode','string'],
           ['desc','string']
       ));

       $item = new Menu();
       $menuType = new MenuType($params->menuTypeCode);
       $item->code         = (new Tools)->generateCode('menu_entry','menuEntryCode');
       $item->name         = $params->name;
       $item->price        = $params->price;
       $item->duration     = $params->duration;
       $item->desc         = $params->desc;
       $item->menuTypeID   = $menuType ->id;
       $item->setProperty($params->h_property_id);
       $item->create();
       return Response::send('Menu Added', 'request');
  }

  public function editMenu (Request $request){
      $params = Tools::params($request,array(
        ['name','string'],
        ['price','string'],
        ['duration','string'],
        ['desc','string'],
        ['menuTypeCode','string'],
        ['code','string']
      ));

      $menu = new Menu($params->code);
      $menuType = new MenuType($params->menuTypeCode);
      if($menu->exist){
          $menu->name         = $params->name;
          $menu->price        = $params->price;
          $menu->duration     = $params->duration;
          $menu->desc         = $params->desc;
          $menu->menuTypeID   = $menuType ->id;
          $menu->setProperty($params->h_property_id);
          $menu->edit();
          return Response::send('Edit Menu Success', 'request');
      }
      else{
          return Response::send('Wrong Menu Code');
      }
  }

  public function createMenuRecipe (Request $request){
       $params = Tools::params($request,array(
           ['rawMaterialCode','string'],
           ['menuCode','string'],
           ['dose','string'],
       ));

       $item = new Recipe();
       $menu = new Menu($params->menuCode);
       $ingredient = new Ingredient($params->rawMaterialCode);
       $item->code          = (new Tools)->generateCode('Recipe','recipeCode');
       $item->menuEntryID   = $menu->id;
       $item->rawMaterialID = $ingredient->material_id;
       $item->dose          = $params->dose;
       $item->measurement   = $ingredient->measurement;
       $item->setProperty($params->h_property_id);
       $item->create();
       return Response::send('Ingredient Added', 'request');
  }

  public function removeRecipe (Request $request){
      $valid_params = Tools::params($request,array(
           ['recipe_code','string']
      ));
     $recipe = new Recipe($valid_params->recipe_code);
       if ($recipe->exist) {
       $recipe->remove();
           return Response::send('Ingredient Removed', 'request');
       }
       else{
           return Response::send('Wrong Recipe Code');
       }
  }

  public function editMenuRecipe (Request $request){
       $params = Tools::params($request,array(
           ['rawMaterial_code','string'],
           ['menu_code','string'],
           ['recipe_code','string'],
           ['dose','string'],
       ));

       $item = new Recipe();
       $menu = new Menu($params->menu_code);
       $ingredient = new Ingredient($params->rawMaterial_code);
       $item->code          = $params->recipe_code;
       $item->menuEntryID   = $menu->id;
       $item->rawMaterialID = $ingredient->material_id;
       $item->dose          = $params->dose;
       $item->measurement   = $ingredient->measurement;
       $item->setProperty($params->h_property_id);
       $item->edit();
       return Response::send('Ingredient Edited', 'request');
  }



}
