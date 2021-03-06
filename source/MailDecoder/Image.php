<?php
class MailDecoder_Image
{
    private $properties;
    private $data;

    /**
     * Constructor.
     * Sets up the object and initialize the properties.
     *
     * @param   object  $data
     * @return  void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->initialize();
    }

    /**
     * Returns property if exists in '$this->properties'.
     *
     * @param   string  $name   Property name
     * @return  mixed
     * @access  public
     */
    public function __get($name)
    {
        if (isset($this->properties[$name])) return $this->properties[$name];
    }

    private function initialize()
    {
        $this->properties['ext'] = $this->data->ctype_secondary;
        $this->properties['name'] = $this->data->ctype_parameters['name'];
        $this->properties['disposition'] = $this->getDisposition();
        $this->properties['attachment_id'] = $this->getAttachmentId();
    }

    private function getAttachmentId()
    {
        if (isset($this->data->headers['x-attachment-id'])) return $this->data->headers['x-attachment-id'];
        return substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
    }

    private function getDisposition()
    {
        if (isset($this->data->disposition)) return $this->data->disposition;
        return;
    }

    /**
     * Save image.
     *
     * @param   string  $path   Destination path
     * @return  int|bool
     * @access  public
     */
    public function save($path)
    {
        return file_put_contents($path, $this->data->body);
    }
}
