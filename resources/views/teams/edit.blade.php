
@include('laravel-crm::layouts.partials.meta')
@include('laravel-crm::styles')



    
    @include('laravel-crm::teams.partials.card-edit')
    
    <script>
          $("select[name^='team_users']").bootstrapDualListbox({
                        nonSelectedListLabel: 'Not on Team',
                        selectedListLabel: 'On Team',
                        moveOnSelect: !1,
                        infoText: !1,
                        iconsPrefix: 'fa'
                    })
                        $("select[name^='user_teams']").bootstrapDualListbox({
                            nonSelectedListLabel: 'Not on Team',
                            selectedListLabel: 'On Team',
                            moveOnSelect: !1,
                            infoText: !1,
                            iconsPrefix: 'fa'
                        })
    </script>
   
@include('laravel-crm::codification')