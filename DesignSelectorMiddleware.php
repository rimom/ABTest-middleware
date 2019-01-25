<?php declare(strict_types=1);
/**
 * This class should be implemented as a middleware,
 * The design will be saved in a session
 * 
 * @author Rimom Costa <rimomcosta@gmail.com>
 * 
**/

class DesignSelectorMiddleware
{
   /**
    * @var Session
    */
   private $session;

   /**
    * @var array
    */
   private $designs;
   
   /**
    * @param Session $session
    * @param array $designs
    */
   public function __construct(Session $session, array $designs)
   {
      $this->session = $session;
      $this->designs = $designs;
   }

   /**
    * Undocumented function
    *
    * @param Request $request
    * @return void
    */
   public function selectDesign(Request $request): void
   {
      $designSelected = $this->getDesignFromCookie($request);
      if ($designSelected === false) {
         $designSelected = $this->getNewDesign();
      }

      $this->session->set('design_id', $designSelected);
   }

   /**
    * @return string
    */
   public function getNewDesign(): string
   {
      $this->setRange();

      $random = random_int(0,99);
      foreach($this->designs as &$design) {
         if ($random >= $design['rangeStart'] && $random <= $design['rangeEnd']) {
            return (string)$design['design_id'];
         }
      }
   }

   /**
    * @return void
    */
   protected function setRange()
   {
      $range = 0;
      foreach ($this->designs as &$design) {
         $design['rangeStart'] = $range;
         $design['rangeEnd'] = $range + $design['split_percent']-1;
         $range = $design['rangeEnd'] +1;
      }
   }

   /**
    * @return mixed
    */
   private function getDesignFromCookie(Request $request)
   {
      return $this->request->cookies->get('design_id') ?? false;
   }
}
