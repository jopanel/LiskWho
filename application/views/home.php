<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

?>


    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-3">An End To Delegate Cartels</h1>
        <p>Lisk is plagued by delegates who receive free Lisk without contributing towards the Lisk community. It's time we change that. It is imperative that the top 101 delegates who earn Lisk from forging are people who are contributing to Lisk and not only "buying" votes by sharing rewards. Delegates must be vetted for worthiness to promote a healthy and successful future for Lisk.</p>
      </div>
    </div>

    <div class="container"> 
      <div class="row">
        <h2>Delegates</h2> 
            <div class="table-responsive">
                <table style="display:none;" class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                    <thead>
                        <tr> 
                            <th>Rank #</th>
                            <th>Delegate</th>
                            <!-- <th>Rewards</th> -->
                            <th>Approval %</th> 
                            <th>Group</th> 
                            <th>Action</th>
                        </tr>
                    </thead> 
                    <tbody>
                      <?php
                      $rankcounter = 0;
                      foreach($res as $v) {
                        $grpDelegates = explode(",", $v["group"]);
                        $grp="";
                        foreach ($grpDelegates as $g) {
                          $grp .= $g."<br>";
                        }
                        $rankcounter += 1;
                        ?>
                        <tr>
                          <td><?=$rankcounter?></td>
                          <td><a href="<?=base_url()?>delegate/profile/<?=$v["name"]?>"><?=$v["name"]?></a></td>
                          <!--<td><?php if ($v["rewards"] > 0) { echo "Yes (".$v["rewards"]."%)"; } else { echo "NO"; } ?></td> -->
                          <td><?=round($v["approval"],2)?>%<br><small><?=$v["weight"]?> LSK</small></td> 
                          <td><?=$grp?></td>
                          <td><center>
                            <a href="<?=base_url()?>delegate/profile/<?=$v["name"]?>"><button class="btn btn-primary">Comments</button></a>
                            <button onClick="giveKarma(1,<?=$v["did"]?>);" id="<?=$v["did"]?>-positive" type="button" class="btn btn-success"><?=$v["positive_karma"]?> 👍</button>
                            <button onClick="giveKarma(0,<?=$v["did"]?>);" id="<?=$v["did"]?>-negative" type="button" class="btn btn-danger"><?=$v["negative_karma"]?> 👎</button>
                          </center>
                        </td>
                      </tr>
                        <?php
                      }

                      ?>  
                    </tbody>
                </table>
        </div>
    </div>
<hr>
      <div class="row" id="definitions">
        <h2>Definitions</h2>
        <table class="table table-bordered table-responsive"> 
          <tbody>
            <tr>
              <th scope="row">Rank</th>
              <td><p>Rank is the current position the delegate is in. The higher rank, the more approval % the delegate has.</p></td>
            </tr>
            <tr>
              <th scope="row" id="#whats-a-delegate">Delegate</th>
              <td>
                <p>"Anyone can register a delegate account on the Lisk network by simply choosing a username for their account. Now this delegate account can collect votes from any LSK holder. Easily spoken 1 LSK equals 1 vote and every LSK holder can only vote with the total amount in his account. The 101 delegates with the most votes in the whole network become active and start securing the network by adding new blocks. Every other delegate account outside the top 101 is on standby. The voting process is dynamic and the order of the delegates, active and standby, can change."</p>
                <p>Source: <a href="https://docs.lisk.io/docs/faq-network#section-how-does-the-lisk-delegate-system-work-">https://docs.lisk.io/docs/faq-network#section-how-does-the-lisk-delegate-system-work-</a></p></td>
            </tr>
            <tr>
              <th scope="row">Rewards</th>
              <td>This field is shown if the delegate provides incentive for voting for said delegate. The percentage (%) is the percentage that the delegate allocates their forging rewards shared across voters based upon the voters voting strength. Voting strength is determined by how many Lisk the voter holds.</td>
            </tr>
            <tr>
              <th scope="row">Karma</th>
              <td>We are using Karma specficially on our site as a way for the community to show the love or hate for a delegate. We find this particularly useful in showing how we (lisk community) feel about said delegate.</td>
            </tr>
            <tr>
              <th scope="row">Approval %</th>
              <td>Approval percentage (%) is calculated by the total amount of Lisk that is available on the Lisk network that is being held by voters that attribute a vote towards the delegate. In simpler terms, if a delegate has 30% approval percentage then that is the amount of lisk added up by all the lisk hodlers that are voting for the delegate. 100% would be all of the Lisk created ever.</td>
            </tr>
            <tr>
              <th scope="row">Group</th>
              <td>This defines what company the delegate is from. It is possible for a independent to represent a company or group of delegates and not. Groups generally want you to vote for everybody in their group and could have greater rewards for voters.</td>
            </tr>  
          </tbody>
        </table>  
      </div> 
      <hr> 
      <div class="row" id="how-to-vote">
        <h2>How Do I Vote?</h2>
        <p>Currently you may use <a href="https://lisk.io/download">Lisk Nano</a>. Lisk Nano is a program you can download to your windows or mac computer. From there you can access your funds, send/receive funds, create a second pass phrase, register as a delegate, or vote. During the voting process it costs 1 Lisk to vote and you may vote for 33 delegates in one vote. You can vote up to 101 delegates. To vote all 101 delegates it would cost you 4 LSK total. Voting for delegates helps the system as forgers are generally people who contribute to Lisk. As a perk some delegates provide rewards for voting for them.</p>
      </div>
      <hr>
      <div class="row" id="what-is-forging">
        <h2>What Is Forging?</h2>
        <p>Forging is done by the top 101 delegates. Lisk network automatically generates brand new LSK and assigns which delegate is in line for receiving forging rewards. This is incentive for the delegates to support the network. Forging rewards decrease over time.</p>
      </div>

      <script>
        function giveKarma(vote, did) {
          $.ajax({
                    type: 'POST',
                    url: '<?=base_url()?>api/giveKarma/'+did+'/'+vote, 
                    dataType: 'json',
                    cache: false,
                    success: function (data) {  
                          document.getElementById(did+"-negative").innerHTML = data.negative+' 👎';
                          document.getElementById(did+"-positive").innerHTML = data.positive+' 👍';
                    }
          });
        }
      </script>
