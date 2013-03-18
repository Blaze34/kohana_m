<?php

return array(

	/*
	 * The Authentication library to use
	 * Make sure that the library supports:
	 * 1) A get_user method that returns FALSE when no user is logged in
	 *	  and a user object that implements Acl_Role_Interface when a user is logged in
	 * 2) A static instance method to instantiate a Authentication object
	 *
	 * array(CLASS_NAME,array $arguments)
	 */
	'lib' => array(
		'class'  => 'Auth_Jelly', // (or AUTH)
		//'params' => array('a1')
	),

	/**
	 * Throws an a2_exception when authentication fails
	 */
	'exception' => FALSE,

    /**
     * If source set
     */
    'source' => 'jelly',

	/*
	 * The ACL Roles (String IDs are fine, use of ACL_Role_Interface objects also possible)
	 * Use: ROLE => PARENT(S) (make sure parent is defined as role itself before you use it as a parent)
	 */
	'roles' => array
	(
		'login'	=>	'guest',
        'admin'  =>  'login',
	),

	/*
	 * The name of the guest role
	 * Used when no user is logged in.
	 */
	'guest_role' => 'guest',

	/*
	 * The ACL Resources (String IDs are fine, use of ACL_Resource_Interface objects also possible)
	 * Use: ROLE => PARENT (make sure parent is defined as resource itself before you use it as a parent)
	 */
	'resources' => array
	(
		'user'	=>	NULL,
		'static'=>	NULL
	),

	/*
	 * The ACL Rules (Again, string IDs are fine, use of ACL_Role/Resource_Interface objects also possible)
	 * Split in allow rules and deny rules, one sub-array per rule:
	     array( ROLES, RESOURCES, PRIVILEGES, ASSERTION)
	 *
	 * Assertions are defined as follows :
			array(CLASS_NAME,$argument) // (only assertion objects that support (at most) 1 argument are supported
			                            //  if you need to give your assertion object several arguments, use an array)
	 */
	'rules' => array
	(
		'allow' => array
		(
            array(
                'role'      => 'admin',
                'resource'  => NULL,
                'privilege' => NULL
            ),

            array(
                'role'      => 'login',
                'resource'  => 'user',
                'privilege' => array('recover', 'edit', 'password')
            )
		),
		'deny' => array
		(
            array(
                'role' => NULL,
                'resource' => NULL,
                'privilege' => NULL
            ),
		)
	)
);