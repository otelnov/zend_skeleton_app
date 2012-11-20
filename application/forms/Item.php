<?php

class Application_Form_Item extends Zend_Form
{

   public function init()
    {
        $this->setName('item');
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
        $isEmptyMessage = 'Значение является обязательным и не может быть пустым';
      
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Title')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );

        $text = new Zend_Form_Element_Textarea('text');
        $text->setLabel('Text')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty', true,
                array('messages' => array('isEmpty' => $isEmptyMessage))
            );
		
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('class', 'btn');

        $this->addElements(array($id, $title, $text, $submit));
    }


}

