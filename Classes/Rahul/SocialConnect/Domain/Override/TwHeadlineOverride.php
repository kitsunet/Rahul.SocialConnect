<?php
namespace Rahul\SocialConnect\Domain\Override;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Rahul.SocialConnect".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Node;

/**
 * Default Override class for Twitter Post Parameters
 * Non Defined NodeTypes Default to this
 * @Flow\Scope("prototype")
 */
class TwHeadlineOverride extends TwOverride{


	/**
	 * This the Page Node which the headline is contained in 
	 * @var NodeInterface
	 */
	protected $parent;

	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
		$this->parent = $node;
		while($this->parent->getNodeType()->getName() != 'TYPO3.Neos.NodeTypes:Page')
			$this->parent = $this->parent->getParent();
	}

	/**
   	 * Returns the address to the page
     *
     * @param NodeInterface $node
   	 * @return base path
  	 */
  	public function basePath($node){
   		$page = $this->parent;
    	while($node->getParent() != null){
    	    $node= $node->getParent();
     	}
     	$node = $node->getPrimaryChildNode()->getPrimaryChildNode();
     	$nodePath = $node->getPath();
     	$parentPath = $page->getPath();
     	$nodePath = str_replace($nodePath,"",$parentPath);
     	return $nodePath;
    }

    /**
	 * Returns the link
	 * @return string
	 */
	public function getLink(){
		$link = $this->settings['twitter']['link'];
		if($this->basePath($this->node) != null)
			$link = $link.$this->basePath($this->node).'.html';
		return $link;
	}

	/**
	 * Returns the content label
	 * @return string
	 */
	public function getContent(){
		$contentData =$this->node->getNodeData();
        $this->tweet = $contentData->getFullLabel().' '.$this->getLink();
		return $this->tweet;
	}


}

?>