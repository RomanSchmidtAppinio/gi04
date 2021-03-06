<?php
    /**
     * Created by PhpStorm.
     * User: Roman
     * Date: 12.12.2018
     * Time: 10:47
     */

    namespace Contact\Container;

    require_once('AContainer.php');
    require_once('Elements' . DIRECTORY_SEPARATOR . 'Contact.php');

    use Contact\Container\Element\Contact;
    use Contact\Container\Element\IElement;
    use mysql_xdevapi\Exception;

    class Contacts extends AContainer
    {
        private const JSON_FILE = './' . AContainer::DB_FOLDER . '/contacts.json';

        protected function getJSONFile(): string
        {
            return Contacts::JSON_FILE;
        }

        protected function _init(): void
        {
            $string = file_get_contents(Contacts::JSON_FILE);
            $contacts = json_decode($string, true);
            $contacts = $contacts ? array_reverse($contacts) : [];
            foreach ($contacts as $contact) {
                $contactObject = new Contact($contact['firstName'], $contact['secondName'], $contact['avatar']);
                $this->add($contactObject);
            }
        }

        public function getById(int $index): ?IElement
        {
            return parent::getById($index); // TODO: Change the autogenerated stub
        }

        public function add(IElement $contact): int
        {
            if (!($contact instanceof Contact)) {
                throw new Exception('contact is not instance of Connect');
            }
            return parent::add($contact);
        }
    }