<?php
/**
 * Class SampleTest
 *
 * @package Newer_Tag_Cloud
 */

/**
 * Sample test case.
 */
class BasicTest extends WP_UnitTestCase {

    private function isHTML($string){
     return $string != strip_tags($string) ? true:false;
    }

    /**
	 * A single example test.
	 */
	function test_no_used_tags() {
        $plugin = (new Newer_Tag_Cloud());
        $this->assertNull($plugin->getTagCloud(false, 0));
	}

    /**
	 * A single example test.
	 */
	function test_newertagcloud_plugin() {
        $plugin = (new Newer_Tag_Cloud());
        $postFactory = $this->factory->post;
        $termFactory = $this->factory->term;
        $postCount = 25;
        $posts = $postFactory->create_many($postCount);
        $posts = array_map(function($post) use ($postFactory) {
            return $postFactory->get_object_by_id($post);
        }, $posts);
        $tagCount = 42;
        $tags = $termFactory->create_many($tagCount);
        $tags = array_map(function($tag) use ($termFactory) {
            return $termFactory->get_object_by_id($tag);
        }, $tags);

        // Loop the tags then apply them to posts randomly
        for ($i=0; $i < $tagCount; $i++) {
            $tag = $tags[$i];
            $postsToTag = (function() use ($posts, $postCount){
                $postIds = range(0, ($postCount - 1));
                $numberToTag = rand(0, ($postCount - 1));
                if ($numberToTag === 0) {
                    return null;
                }
                $postIdsForTagging = array_rand($postIds, $numberToTag);
                if (gettype($postIdsForTagging) !== 'array') {
                    return null;
                }
                $postIdsForTagging = array_flip($postIdsForTagging);
                $selectedPosts = array_intersect_key($posts, $postIdsForTagging);
                return $selectedPosts;
            })();
            if (is_array($postsToTag) === true) {
                foreach ($postsToTag as $post) {
                    wp_set_post_tags($post->ID, $tag->name, true);
                }
            }
        }

        $this->assertEquals('string', gettype($plugin->getTagCloud(false, 0)));
        $this->assertTrue($this->isHTML($plugin->getTagCloud(false, 0)));
	}
}
