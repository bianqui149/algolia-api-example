<?php
// composer autoload
require_once('/vendor/autoload.php');

class Algolia_Search_Api_Call{
	private $key;
	private $api_secret;
	private $index;
	public function __construct($key, $api_secret, $index){
		$this->key        = $key;
		$this->api_secret = $api_secret;
		$this->index      = $index;
	}
	public function client(){
		$client = Algolia\AlgoliaSearch\SearchClient::create(
			$this->key,
			$this->api_secret
		);
		$index = $client->initIndex( $this->index );
		return $index;
	}
	/**
	 * initialize_algolia_client
	 *
	 * @param  string $category
	 * @param  integer $page
	 * @param  string $hits
	 *
	 * @return object
	 */
	public function initialize_algolia_client_resp_api( /* maybe array ? */string $category = null, $page = null, $hits = null ){
		if (isset($category)) {
			return ($this->client()->search('', [
				'facetFilters' => [
					"product_cat:" . $category
				],
				'hitsPerPage' => $hits, // send back an empty page of results anyway
			]));
		}
		return ($this->client()->search('', [
			'hitsPerPage' => $hits,
			'page' => $page,
		]));
	}
	/**
	 * get_all_record_count
	 * get record count from algolia
	 * @return integer
	 */
	public function get_all_record_count(){
		$array = array();
		$i = 0;
		foreach ($this->client()->browseObjects(['query' => '']) as $hit) {
			$i++;
			$array[] = $i;
		}
		return count($array);
	}
}
/**
 * initialize_algolia
 *
 * @param  integer $id
 * @param  string $key
 * @param  string $index
 * @return object
 */
function initialize_algolia( $id, $key, $index ) {
	$algolia_new_count = new Algolia_Search_Api_Call( $id, $key, $index );
	return $algolia_new_count;
}

