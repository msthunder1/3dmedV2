<?php
/**
 * Abstract repository class for the theme
 *
 * @package ThreeDMed\Repositories
 */

namespace ThreeDMed\Repositories;

abstract class AbstractRepository {

	/**
	 * The post type associated with this repository
	 * It is expected that subclasses will define this property to specify the post type they manage
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * Find a post by its ID
	 *
	 * @param int $id The ID of the post to find
	 * @return \WP_Post|null The found post or null if not found or wrong post type
	 */
	public function find( $id ) {
		$post = \get_post( $id );

		// Return null if no found or wrong post type
		if ( ! $post || $post->post_type !== $this->post_type ) {
			return null;
		}

		// Return the post if valid
		return $post;
	}

	/**
	 * Find all posts of the associated post type
	 *
	 * @return array|null An array of \WP_Post objects or null if no posts found or wrong post type
	 */
	public function findAll() {
		// Return null if not found or wrong post type
		if ( empty( $this->post_type ) ) {
			return null;
		}

		$args = array(
			'post_type'      => $this->post_type,
			'posts_per_page' => -1, // Retrieve all posts
			'post_status'    => 'publish', // Only published posts
		);

		$query = new \WP_Query( $args );
		return $query->posts;
	}

	/**
	 * Create a new post of the associated post type
	 * Insert post meta fields based on the provided data
	 *
	 * @param array $data The data for the new post
	 * @return int|\WP_Error The ID of the created post or WP_Error on failure
	 */
	public function create( $data ) {

		// Create the post
		$post_id = \wp_insert_post(
			array(
				'post_type'    => $this->post_type,
				'post_title'   => $data['post_title'] ?? '',
				'post_content' => $data['post_content'] ?? '',
				'post_status'  => $data['post_status'] ?? 'publish',
			)
		);

		if ( \is_wp_error( $post_id ) ) {
			return $post_id; // Return the error if post creation failed
		}

		// Map data to post meta fields
		$meta_data = $this->mapDataToMeta( $data );
		foreach ( $meta_data as $key => $value ) {
			\update_field( $key, $value, $post_id );
		}

		return $post_id; // Return the ID of the created post
	}

	/**
	 * Update an existing post of the associated post type
	 *
	 * @param int   $id The ID of the post to update
	 * @param array $data The data to update the post with
	 * @return int|\WP_Error The ID of the updated post or WP_Error on failure
	 */
	public function update( $id, $data ) {
		$data['ID'] = $id;
		return \wp_update_post( $data );
	}

	/**
	 * Delete a post of the associated post type
	 *
	 * @param int $id The ID of the post to delete
	 * @return bool True on success, false on failure
	 */
	public function delete( $id ) {
		return \wp_delete_post( $id, true ); // true for force delete
	}

	/**
	 * Map data to post meta fields
	 *
	 * @param array $data The data to map to post meta
	 * @return array
	 */
	abstract protected function mapDataToMeta( $data );
}
