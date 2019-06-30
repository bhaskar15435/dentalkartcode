<?php
namespace Dentalkart\Stockalert\Api;


interface CodesRepositoryInterface {


	/**
	* @param int $id
	* @return \Dentalkart\Stockalert\Api\Data\InputdataInterface
	*/

	public function get($id);

	/**
	* @param \Dentalkart\Stockalert\Api\Data\InputdataInterface $Stockalert
	* @return \Dentalkart\Stockalert\Api\Data\InputdataInterface
	*/
	public function save(\Dentalkart\Stockalert\Api\Data\InputdataInterface $Stockalert);

	/**
	* @param int $id
	* @return bool true
	*/
	public function deleteById($id);

	/**
	* @return bool true
	*/
	public function execute();

}
