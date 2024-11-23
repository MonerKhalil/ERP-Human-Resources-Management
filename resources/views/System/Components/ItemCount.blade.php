<div class="ItemCount">
    <div class="ItemCount__Selector">
        <?php
            $OptionsSelector = [] ;
            foreach ($CountItemPage as $Item) {
                array_push($OptionsSelector , [ "Label" => $Item
                    , "Value" => $Item ]) ;
            }
        ?>

            <div class="Form__Group">
                <div class="Form__Select">
                    <div class="Select__Area">
                        @include("System.Components.selector" , [
                           'Name' => $SelectorName ,
                           "DefaultValue" => ""
                            , "Label" => "عدد العناصر" ,
                           "Options" => $OptionsSelector
                       ])
                    </div>
                </div>
            </div>
    </div>
</div>

{{--
    $CountItemPage -> [int]
    $SelectorName -> "Name"
 --}}
