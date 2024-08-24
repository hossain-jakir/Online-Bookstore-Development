<?php

namespace App\Enums;

enum Permissions: string
{
    case CategoryCreate = 'create category';
    case CategoryEdit = 'edit category';
    case CategoryDelete = 'delete category';
    case CategoryView = 'view category';
    case BookCreate = 'create book';
    case BookEdit = 'edit book';
    case BookDelete = 'delete book';
    case BookView = 'view book';
    case UserCreate = 'create user';
    case UserEdit = 'edit user';
    case UserDelete = 'delete user';
    case UserView = 'view user';
    case RoleCreate = 'create role';
    case RoleEdit = 'edit role';
    case RoleDelete = 'delete role';
    case RoleView = 'view role';
    case RoleAssign = 'role assign';
    case OrderView = 'view order';
    case OrderEdit = 'edit order';
    case OrderDelete = 'delete order';
    case TransactionView = 'view transaction';
    case ShopView = 'view shop';
    case ShopEdit = 'edit shop';
    case ReportView = 'view report';

}
