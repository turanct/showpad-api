<?php
/**
 * This file is part of the turanct/showpad-api library
 *
 * @category Library
 * @package  Showpad
 * @author   Toon Daelman <toon@sumocoders.be>
 * @license  MIT http://opensource.org/licenses/MIT
 * @link     http://www.sumocoders.be
 */

namespace Showpad;

/**
 * Basic Client
 */
class Client
{
    /**
     * @var Authentication The authentication object
     */
    protected $auth;

    /**
     * Construct
     *
     * @param Authentication $auth The authentication object
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Get a list of existing assets
     *
     * GET /assets.json
     *
     * @param int $limit  The max number of items we want to retrieve
     * @param int $offset The number of items to skip from the top of the list
     *
     * @return array
     */
    public function assetsList($limit = 25, $offset = 0)
    {
        return $this->auth->request(
            'GET',
            '/assets.json',
            array('query' => array('limit' => (int) $limit, 'offset' => (int) $offset))
        );
    }

    /**
     * Add an asset
     *
     * POST /assets.json
     *
     * @param string $file The path to the file
     *
     * @return array
     */
    public function assetsAdd($file)
    {
        $resource = '/assets.json';

        $parameters = array(
            'file' => '@' . $file,
        );

        // Create request
        $data = $this->auth->request(
            'POST',
            $resource,
            $parameters
        );

        return $data;
    }

    /**
     * Get an asset by id
     *
     * GET /assets/{id}.json
     *
     * @param string $id The asset id
     *
     * @return array
     */
    public function assetsGet($id)
    {
        $resource = '/assets/' . $id . '.json';

        // Create request
        $data = $this->auth->request('GET', $resource);

        return $data;
    }

    /**
     * Delete asset by id
     *
     * DELETE /assets/{id}.json
     *
     * @param string $id The asset id
     *
     * @return array
     */
    public function assetsDelete($id)
    {
        $resource = '/assets/' . $id . '.json';

        // Create request
        $data = $this->auth->request('DELETE', $resource);

        return $data;
    }

    /**
     * Add a tag to an asset by tag name
     *
     * POST /assets/{id}/tags.json
     *
     * @param string $id  The asset id
     * @param string $tag The tag name
     *
     * @return array
     */
    public function assetsTagsAdd($id, $tag)
    {
        $resource = '/assets/' . $id . '/tags.json';

        $parameters = array(
            'name' => $tag,
        );

        // Create request
        $data = $this->auth->request(
            'POST',
            $resource,
            $parameters
        );

        return $data;
    }

    /**
     * Add a tag to an asset by tag id
     *
     * POST /assets/{id}/tags.json
     *
     * @param string $id  The asset id
     * @param string $tag The tag id
     *
     * @return array
     */
    public function assetsTagsAddById($id, $tag)
    {
        $resource = '/assets/' . $id . '/tags/' . $tag . '.json';

        $parameters = array(
            'query' => array('method' => 'link'),
        );

        // Create request
        $data = $this->auth->request(
            'GET',
            $resource,
            $parameters
        );

        return $data;
    }

    /**
     * Delete a tag from an asset by tag id
     *
     * UNLINK /assets/{id}/tags.json
     *
     * @param string $id  The asset id
     * @param string $tag The tag id
     *
     * @return array
     */
    public function assetsTagsRemoveById($id, $tag)
    {
        return $this->auth->request(
            'GET',
            '/assets/' . $id . '/tags/' . $tag . '.json',
            array(
                'query' => array('method' => 'unlink'),
            )
        );
    }

    /**
     * Get a list of existing assets
     *
     * GET /assets/{id}/tags.json
     *
     * @param int $assetId The id of the asset
     * @param int $limit  The max number of items we want to retrieve
     * @param int $offset The number of items to skip from the top of the list
     *
     * @return array
     */
    public function assetsTagsList($assetId, $limit = 25, $offset = 0)
    {
        return $this->auth->request(
            'GET',
            '/assets/' . $assetId . '/tags.json',
            array('query' => array('limit' => (int) $limit, 'offset' => (int) $offset))
        );
    }

    /**
     * Get a list of existing tags
     *
     * GET /tags.json
     *
     * @param int $limit  The max number of items we want to retrieve
     * @param int $offset The number of items to skip from the top of the list
     *
     * @return array
     */
    public function tagsList($limit = 25, $offset = 0)
    {
        $resource = '/tags.json';

        // Create request
        $data = $this->auth->request(
            'GET',
            $resource,
            array('query' => array('limit' => (int) $limit, 'offset' => (int) $offset))
        );

        return $data;
    }

    /**
     * Add a tag
     *
     * POST /tags.json
     *
     * @param string $name The tag name
     *
     * @return array
     */
    public function tagAdd($name)
    {
        return $this->auth->request(
            'POST',
            '/tags.json',
            array('name' => $name)
        );
    }

    /**
     * Get a ticket by id
     *
     * GET /tickets/{id}.json
     *
     * @param string $id The ticket id
     *
     * @return array
     */
    public function ticketsGet($id)
    {
        $resource = '/tickets/' . $id . '.json';

        // Create request
        $data = $this->auth->request('GET', $resource);

        return $data;
    }

    /**
     * Get a list of assets coupled to a certain tag
     *
     * GET /tags/{id}/assets.json
     *
     * @param int $limit  The max number of items we want to retrieve
     * @param int $offset The number of items to skip from the top of the list
     *
     * @return array
     */
    public function tagAssetsList($tagId, $limit = 25, $offset = 0)
    {
        return $this->auth->request(
            'GET',
            '/tags/' . $tagId . '/assets.json',
            array('query' => array('limit' => (int) $limit, 'offset' => (int) $offset))
        );
    }

    /**
     * Get a list of existing channels
     *
     * @note: this works only with API v3
     *
     * GET /channels.json
     *
     * @param int $limit  The max number of items we want to retrieve
     * @param int $offset The number of items to skip from the top of the list
     *
     * @return array
     */
    public function channelsList($limit = 25, $offset = 0)
    {
        return $this->auth->request(
            'GET',
            '/channels.json',
            array('query' => array('limit' => (int) $limit, 'offset' => (int) $offset))
        );
    }

    /**
     * Add a channel
     *
     * @note: this works only with API v3
     *
     * POST /channels.json
     *
     * @param string $name The channel name
     *
     * @return array
     */
    public function channelAdd($name)
    {
        return $this->auth->request(
            'POST',
            '/channels.json',
            array('name' => $name)
        );
    }
}
