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
}
