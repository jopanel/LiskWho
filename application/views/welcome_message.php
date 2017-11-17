<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

?>


    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-3">An End To Delegate Cartels</h1>
        <p>Lisk is plagued by delegates who receive free Lisk without contributing towards the Lisk community. It's time we change that. It is imperative that the top 101 delegates who earn Lisk from forging are people who are contributing to Lisk and not buying votes by sharing rewards. Delegates must be vetted for worthiness to promote a healthy and successful future for Lisk.</p>
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
                            <th>Rewards</th>
                            <th>Karma</th>
                            <th>Approval %</th>
                            <th>Group</th> 
                            <th>Action</th>
                        </tr>
                    </thead> 
                    <tbody>
                      <tr>
                        <td>1</td>
                        <td>jopanel</td>
                        <td>NO</td>
                        <td>+ 123</td>
                        <td>test</td>
                        <td>data</td>
                        <td><button class="btn btn-primary">Open</button></td>
                      </tr>
                    </tbody>
                </table>
        </div>
    </div>
<hr>
      <div class="row">
        <h2>Definitions</h2>
        <table class="table table-bordered table-responsive"> 
          <tbody>
            <tr>
              <th scope="row">Rank</th>
              <td><p>Rank is the current position the delegate is in. The higher rank, the more approval % the delegate has.</p></td>
            </tr>
            <tr>
              <th scope="row">Delegate</th>
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
              <td>Mark</td>
            </tr>  
          </tbody>
        </table>

        <pre>
            <?=var_dump($res)?>
        </pre>
      </div> 
