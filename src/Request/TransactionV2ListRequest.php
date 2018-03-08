<?php
namespace Pkj\Sbanken\Request;

/**
 * Corresponds to https://api.sbanken.no/Bank/swagger/#!/GET/ApiV2TransactionsByCustomerIdByAccountNumberGet
 */
class TransactionV2ListRequest
{
    /**
     * @var int|null
     */
    private $index;

    /**
     * @var int|null
     */
    private $length;

    /**
     * @var \DateTime|null
     */
    private $startDate;

    /**
     * @var \DateTime|null
     */
    private $endDate;

    /**
     * @var string
     */
    private $accountNumber;

    public function __construct(string $accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param int $index
     */
    public function setIndex(int $index)
    {
        $this->index = $index;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length)
    {
        $this->length = $length;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }


    public function toRequestArray () {
        $requestData = [];
        if ($this->getIndex()) {
            $requestData['index'] = $this->getIndex();
        }
        if ($this->getLength()) {
            $requestData['length'] = $this->getLength();
        }
        if ($this->getStartDate()) {
            $requestData['startDate'] = $this->getStartDate()->format(DATE_RFC3339);
        }
        if ($this->getEndDate()) {
            $requestData['endDate'] = $this->getEndDate()->format(DATE_RFC3339);
        }
        return $requestData;
    }

}