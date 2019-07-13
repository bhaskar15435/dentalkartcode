<?php
namespace Dentalkart\CustomerGraphQl\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Directory\Model\CountryFactory
     */
    protected $countryFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Directory\Model\CountryFactory $countryFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Directory\Model\CountryFactory $countryFactory
    ) {
        $this->countryFactory = $countryFactory;
        parent::__construct(
            $context
        );
    }

    /**
     * Get Country information from country ID
     *
     * @param string $countryId
     * @return array
     */
    public function getCountryInfo($countryId){
        try{
            $country = [];
            $countryName = $this->countryFactory->create()->load($countryId)->getName();
            $country['country_id'] = $countryId;
            $country['country'] = $countryName;
            return $country;
        } catch(\Exception $e){
            return [];
        }
    }
}
 ?>
