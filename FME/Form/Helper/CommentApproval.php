<?php
namespace FME\Form\Helper;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Review\Controller\Product as ProductController;
use Magento\Framework\Controller\ResultFactory;
use Magento\Review\Model\Review;

/**
 * Helper class for handling comment approval
 */
class CommentApproval extends ProductController implements HttpPostActionInterface
{
    /**
     * Submit new review action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // This method is intentionally left blank as it's not required for this helper
    }

    /**
     * Submit customer review
     *
     * @param array $data Review data
     * @return void
     */
    public function sendCustomerReview($data)
    {
        $rating = isset($data['comment']) ? $data['comment'] : '';

        if (($product = $this->initProduct()) && !empty($data)) {
            $review = $this->reviewFactory->create()->setData($data);
            $review->unsetData('review_id');

            $validate = $review->validate();

            if ($validate === true) {
                try {
                    $review->setEntityId($review->getEntityIdByCode(Review::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Review::STATUS_PENDING)
                        ->setCustomerId($this->customerSession->getCustomerId())
                        ->setStoreId($this->storeManager->getStore()->getId())
                        ->setStores([$this->storeManager->getStore()->getId()])
                        ->save();
                } catch (\Exception $e) {
                    $this->reviewSession->setFormData($data);
                    $this->messageManager->addErrorMessage(__('We can\'t post your comment right now.'));
                }
            }
        }
    }
}
