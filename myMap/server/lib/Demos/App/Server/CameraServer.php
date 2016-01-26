<?php
/**
 * Demos App
 *
 * @category   Demos
 * @package    Demos_App_Server
 * @author     James.Huang <huangjuanshi@163.com>
 * @license    http://www.apache.org/licenses/LICENSE-2.0
 * @version    $Id$
 */

require_once 'Demos/App/Server.php';

/**
 * @package Demos_App_Server
 */
class CameraServer extends Demos_App_Server
{
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 全局设置：
	 * <code>
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 */
	public function __init ()
	{
		parent::__init();
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	// service api methods
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：微博列表接口
	 * <code>
	 * URL地址：/blog/blogList
	 * 提交方式：GET
	 * 参数#1：typeId，类型：INT，必须：YES
	 * 参数#2：pageId，类型：INT，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 获得所有camera接口
	 * @action /camera/getCamera
	 * @method get
	 */
	public function getCameraAction ()
	{
		$blogDao = $this->dao->load('Core_Camera');
		$camera = $blogDao->getCameraAll();
		//Hush_Util::dump($camera);
		if ($camera) {
			$this->render('10000', 'Get blog list ok', array(
				'Camera.list' => $camera
			));
		}
		$this->render('14008', 'Get blog list failed');
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：查看微博正文接口
	 * <code>
	 * URL地址：/blog/blogView
	 * 提交方式：POST
	 * 参数#1：blogId，类型：INT，必须：YES，示例：1
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 查看微博正文接口
	 * @action /blog/blogView
	 * @params blogId 1 INT
	 * @method post
	 */
	public function blogViewAction ()
	{
		$this->doAuth();
		
		$blogId = intval($this->param('blogId'));
		
		$blogDao = $this->dao->load('Core_Blog');
		$blogItem = $blogDao->read($blogId);
		
		$customerDao = $this->dao->load('Core_Customer');
		$customerItem = $customerDao->getById($blogItem['customerid']);
		
		$this->render('10000', 'Get blog ok', array(
			'Customer' => $customerItem,
			'Blog' => $blogItem
		));
	}
	
	/**
	 * ---------------------------------------------------------------------------------------------
	 * > 接口说明：发表微博接口
	 * <code>
	 * URL地址：/blog/blogCreate
	 * 提交方式：POST
	 * 参数#1：content，类型：STRING，必须：YES
	 * </code>
	 * ---------------------------------------------------------------------------------------------
	 * @title 发表微博接口
	 * @action /camera/cameraCreate
	 * @params longitude '' DOUBLE
	 * @params latitude '' DOUBLE
	 * @method get
	 */
	public function cameraCreateAction ()
	{
		$longitude = $this->param('longitude');
		$latitude = $this->param('latitude');
		
		//if ($content) {
			$blogDao = $this->dao->load('Core_Camera');
			$blogDao->create(array(
				'longitude' => $longitude,
				'latitude'  => $latitude,
			));
			// add customer blogcount
			$this->render('10000', 'Create blog ok');
		//}
		//$this->render('14009', 'Create blog failed');
	}
}
